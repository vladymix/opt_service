package com.ssr.otp.api

import com.ssr.otp.models.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import java.util.*

class OtpApi private constructor() {
    private val passAmazon = "d93b2c6007d15f89b21ef9569347d44632714b25912f2a419017a0f46cb7e123"
    private val userAmazon = "exampleuser@amazon.com"
    private val clienteEmail = "cliente@correo.com"

    private var loginResponse : LoginResponse?=null


    fun pushRegister(token_push:String, callback: ApiResponse<String>){

        service.pushRegister(PushRequest(clienteEmail, token_push)).enqueue(object :Callback<PushResponse>{
            override fun onResponse(call: Call<PushResponse>, response: Response<PushResponse>) {
                if(response.code()== 200){
                    callback.apiResult("Available notifications")
                }else{
                    callback.apiError("Error code:"+response.code())
                }
            }

            override fun onFailure(call: Call<PushResponse>, t: Throwable) {
                callback.apiError(t.message)
            }

        })
    }

    fun login(callback:ApiResponse<String?>) {
        service.login(LoginRequest(userAmazon, passAmazon))
            .enqueue(object : Callback<LoginResponse> {
                override fun onResponse(
                    call: Call<LoginResponse>,
                    response: Response<LoginResponse>
                ) {
                    if(response.code()==200){
                        loginResponse = response.body()
                        callback.apiResult(loginResponse?.jwt)
                    }else{
                        loginResponse = null
                        callback.apiError(response.code().toString())
                    }

                }
                override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                     loginResponse = null
                     callback.apiError(t.message)
                }

            })
    }

    companion object {
        private var instance: OtpApi? = null
        fun getInstance(): OtpApi {
            if (instance == null) {
                instance = OtpApi()
            }
            return instance!!
        }
    }

    private val service: IOtpApi

    init {
        val retrofit = Retrofit.Builder()
            .baseUrl("http://192.168.1.150/api/")
            .addConverterFactory(GsonConverterFactory.create())
            .build()
        service = retrofit.create(IOtpApi::class.java)
    }

    fun generateCode(delivery:Delivery, callback:ApiResponse<Delivery>){
        loginResponse?.let {
            service.generateCode(GenerateRequest(it.jwt,delivery.trackId,clienteEmail)).enqueue(object :Callback<GenerateResponse>{
                override fun onResponse(
                    call: Call<GenerateResponse>,
                    response: Response<GenerateResponse>
                ) {
                   if(response.code()==200){
                       response.body()?.let {
                           delivery.jwt_otp = it.jwt_otp
                           delivery.status = it.estado
                       }
                       callback.apiResult(delivery)
                   }else{
                       callback.apiError("Error when generate code:"+response.code())
                   }
                }
                override fun onFailure(call: Call<GenerateResponse>, t: Throwable) {
                    callback.apiError(t.message)
                }
            })
        }

        if(loginResponse==null){
            callback.apiError("User no register")
        }

    }

    var listener_jwt_otp:String?=null

    fun registerListener(delivery:Delivery, callback:ApiResponse<Delivery>){
        if(loginResponse==null){
            callback.apiError("User no register")
            return
        }

        listener_jwt_otp = delivery.jwt_otp

        callerRecursive(delivery,callback)

    }
    fun removeLister(){
        listener_jwt_otp =null
    }

    fun getStatus(delivery: Delivery, callback: ApiResponse<Delivery>) {
        loginResponse?.let {token->
            delivery.jwt_otp?.let {
                if(delivery.status != "2"){
                    service.getStatus(StatusRequest(token.jwt,it,delivery.trackId)).enqueue(object :Callback<StatusResponse>{
                        override fun onResponse(
                            call: Call<StatusResponse>,
                            response: Response<StatusResponse>
                        ) {
                            if(response.code()==200){
                                response.body()?.let {
                                    delivery.status = it.status
                                    callback.apiResult(delivery)
                                }
                            }else{
                                callback.apiError("Error")
                            }
                        }
                        override fun onFailure(call: Call<StatusResponse>, t: Throwable) {
                            callback.apiError(t.message)
                        }
                    })
                }
            }
        }
    }

    fun validateCode(tracker_id: String,otp_pass:String, callback: ApiResponse<String>) {
        loginResponse?.let { token ->
            service.validateCode(ValidateRequest(token.jwt, tracker_id, otp_pass))
                .enqueue(object : Callback<StatusResponse> {
                    override fun onResponse(
                        call: Call<StatusResponse>,
                        response: Response<StatusResponse>
                    ) {
                        if (response.code() == 200) {
                            response.body()?.let {
                                callback.apiResult(it.status)
                            }
                        } else {
                            callback.apiError(response.code().toString())
                        }
                    }

                    override fun onFailure(call: Call<StatusResponse>, t: Throwable) {
                        callback.apiError(t.message)
                    }
                })
        }

    }


    fun getStatusClient(delivery: Delivery, callback: ApiResponse<Delivery>) {
        loginResponse?.let { token ->
            if (delivery.status != "2") {
                service.getStatusClient(StatusClientRequest(token.jwt, delivery.trackId))
                    .enqueue(object : Callback<StatusResponse> {
                        override fun onResponse(
                            call: Call<StatusResponse>,
                            response: Response<StatusResponse>
                        ) {
                            if (response.code() == 200) {
                                response.body()?.let {
                                    delivery.status = it.status
                                    callback.apiResult(delivery)
                                }
                            } else {
                                callback.apiError("Error")
                            }
                        }

                        override fun onFailure(call: Call<StatusResponse>, t: Throwable) {
                            callback.apiError(t.message)
                        }
                    })
            }
        }

    }

    private fun callerRecursive(delivery: Delivery, callback: ApiResponse<Delivery>) {
        listener_jwt_otp?.let { jwt_otp->
            loginResponse?.let {
                if(delivery.status != "2"){
                    this.getStatus(delivery, object:ApiResponse<Delivery>{
                        override fun apiResult(data: Delivery) {
                            callback.apiResult(data)
                            Timer().schedule(object : TimerTask() {
                                override fun run() {
                                    callerRecursive(delivery,callback)
                                }
                            },2000)
                        }

                        override fun apiError(error: String?) {
                            Timer().schedule(object : TimerTask() {
                                override fun run() {
                                    callerRecursive(delivery,callback)
                                }
                            },2000)
                        }
                    })
                }
            }
        }
    }

}
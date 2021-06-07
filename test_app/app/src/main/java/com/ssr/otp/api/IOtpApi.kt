package com.ssr.otp.api

import com.ssr.otp.models.*
import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.POST


interface IOtpApi {

    @POST("login")
    fun login(@Body request: LoginRequest): Call<LoginResponse>

    @POST("pushregister")
    fun pushRegister(@Body request: PushRequest):Call<PushResponse>

    @POST("generatecode")
    fun generateCode(@Body request: GenerateRequest):Call<GenerateResponse>

    @POST("status")
    fun getStatus(@Body request: StatusRequest):Call<StatusResponse>

    @POST("statusclient")
    fun getStatusClient(@Body request: StatusClientRequest):Call<StatusResponse>

    @POST("validatecode")
    fun validateCode(@Body request: ValidateRequest):Call<StatusResponse>
}
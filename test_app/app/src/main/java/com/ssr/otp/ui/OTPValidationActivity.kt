package com.ssr.otp.ui

import android.os.Bundle
import android.view.View
import android.widget.*
import com.ssr.otp.BaseActivity
import com.ssr.otp.Extentions.getImageStatus
import com.ssr.otp.R
import com.ssr.otp.api.ApiResponse
import com.ssr.otp.api.OtpApi

class OTPValidationActivity : BaseActivity(), ApiResponse<String> {

    lateinit var imageStatus: ImageView
    lateinit var trackid: TextView
    lateinit var yourCode: EditText
    lateinit var btnValidate: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_customer)

        imageStatus = findViewById(R.id.imageStatus)
        trackid = findViewById(R.id.trackid)
        btnValidate = findViewById(R.id.btnValidate)

       yourCode = findViewById(R.id.yourCode)
        findViewById<View>(R.id.btnOnBack).setOnClickListener { this.onBackPressed() }
        findViewById<View>(R.id.btnValidate).setOnClickListener { this.onValidateCode() }

        this.bindValues()
    }

    private fun onValidateCode() {
        if(yourCode.text.isNullOrBlank()){
            yourCode.error = "this field can not be blank"
            return
        }
        // Get Status Client
        appLogic.itemSelected?.let {
            OtpApi.getInstance().validateCode(it.trackId,yourCode.text.toString(),this)
        }

    }

    private fun bindValues() {
        appLogic.itemSelected?.let {
            imageStatus.setImageResource(it.status.getImageStatus())
            trackid.text = it.trackId
        }
    }

    override fun apiResult(data: String) {
        appLogic.itemSelected?.status = data
        bindValues()
        if(data == "2"){
            Toast.makeText(this, "Your order has been delivered correctly", Toast.LENGTH_LONG).show()
        }
    }

    override fun apiError(error: String?) {


      val message =  error?.let {
            when (error){
                "406"-> "The code entered is not correct.\n" +
                        "Reasons:\n" +
                        "Verify that the code is correct.\n" +
                        "If you made a last minute change to your order, the product they are trying to deliver to you is not the same."
                else -> "Error $error"
            }
        }
        Toast.makeText(this, message, Toast.LENGTH_LONG).show()
    }

}
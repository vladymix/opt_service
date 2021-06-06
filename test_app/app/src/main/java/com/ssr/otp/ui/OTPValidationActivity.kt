package com.ssr.otp.ui

import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import com.ssr.otp.BaseActivity
import com.ssr.otp.Extentions.getImageStatus
import com.ssr.otp.R

class OTPValidationActivity : BaseActivity() {

    lateinit var imageStatus: ImageView
    lateinit var trackid: TextView
    lateinit var btnValidate: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_customer)

        imageStatus = findViewById(R.id.imageStatus)
        trackid = findViewById(R.id.trackid)
        btnValidate = findViewById(R.id.btnValidate)

        findViewById<View>(R.id.btnOnBack).setOnClickListener { this.onBackPressed() }

        this.bindValues()
    }

    private fun bindValues() {
        appLogic.itemSelected?.let {
            imageStatus.setImageResource(it.status.getImageStatus())
            trackid.text = it.trackId
        }
    }

}
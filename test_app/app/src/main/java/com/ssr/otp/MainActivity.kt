package com.ssr.otp

import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.Toast
import com.ssr.otp.api.ApiResponse
import com.ssr.otp.api.OtpApi
import com.ssr.otp.ui.CustomerOrders
import com.ssr.otp.ui.DeliveriesActivity

class MainActivity : BaseActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        findViewById<View>(R.id.btnDelivery).setOnClickListener {
           startActivity(Intent(this, DeliveriesActivity::class.java))
        }

        findViewById<View>(R.id.btnCustomer).setOnClickListener {
            startActivity(Intent(this, CustomerOrders::class.java))
        }
        this.doLogin()
    }

    fun doLogin(){
        OtpApi.getInstance().login(object :ApiResponse<String?>{
            override fun apiResult(data: String?) {
                Toast.makeText(this@MainActivity, "User registered", Toast.LENGTH_LONG ).show()
            }

            override fun apiError(error: String?) {
                Toast.makeText(this@MainActivity, error, Toast.LENGTH_LONG ).show()
            }
        })
    }
}
package com.ssr.otp.ui

import android.content.Intent
import android.os.Bundle
import android.os.Handler
import android.util.Log
import android.view.View
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import com.google.android.gms.tasks.OnCompleteListener
import com.google.firebase.messaging.FirebaseMessaging
import com.ssr.otp.BaseActivity
import com.ssr.otp.R
import com.ssr.otp.adapters.DeliveryAdapter
import com.ssr.otp.api.ApiResponse
import com.ssr.otp.api.OtpApi
import com.ssr.otp.models.Delivery

class CustomerOrders : BaseActivity(), ApiResponse<String> {
    val TAG = "TAG"
    var callerApi = true

    private val mAdapter = DeliveryAdapter { onItemSelected(it) }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_deliveries)

        findViewById<RecyclerView>(R.id.recicleView).adapter = mAdapter
        findViewById<View>(R.id.btnOnBack).setOnClickListener { this.onBackPressed() }

        refreshToken()
    }

    override fun onResume() {
        super.onResume()
        callerApi=true
        mAdapter.setSource(appLogic.getDeliveries())
        refreshData()
    }

    override fun onDestroy() {
        super.onDestroy()
        callerApi = false

    }

    private fun onItemSelected(item: Delivery) {
        appLogic.itemSelected = item
        startActivity(Intent(this, OTPValidationActivity::class.java))
    }

    fun refreshData(){
        if(callerApi){
            Handler().postDelayed({
                mAdapter.setSource(appLogic.getDeliveries())
                refreshData()
            }, 2000)
        }

    }


    fun refreshToken() {
        FirebaseMessaging.getInstance().token.addOnCompleteListener(OnCompleteListener { task ->
            if (!task.isSuccessful) {
                Toast.makeText(this, "Error can`t received notifications",Toast.LENGTH_LONG).show()
                Log.w(TAG, "Fetching FCM registration token failed", task.exception)
                return@OnCompleteListener
            }
            // Get new FCM registration token
            val token = task.result
            OtpApi.getInstance().pushRegister(token!!,this)
        })
    }

    override fun apiResult(data: String) {
        Toast.makeText(baseContext, data, Toast.LENGTH_SHORT).show()
    }

    override fun apiError(error: String?) {
        Toast.makeText(baseContext, error, Toast.LENGTH_SHORT).show()
    }
}
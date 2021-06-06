package com.ssr.otp.ui

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import com.google.android.gms.tasks.OnCompleteListener
import com.google.firebase.messaging.FirebaseMessaging
import com.ssr.otp.BaseActivity
import com.ssr.otp.R
import com.ssr.otp.adapters.DeliveryAdapter
import com.ssr.otp.models.Delivery

class CustomerOrders : BaseActivity() {
    val TAG = "TAG"

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
        mAdapter.setSource(appLogic.getDeliveries())
    }

    private fun onItemSelected(item: Delivery) {
        appLogic.itemSelected = item
        startActivity(Intent(this, OTPValidationActivity::class.java))
    }


    fun refreshToken() {
        FirebaseMessaging.getInstance().token.addOnCompleteListener(OnCompleteListener { task ->
            if (!task.isSuccessful) {
                Log.w(TAG, "Fetching FCM registration token failed", task.exception)
                return@OnCompleteListener
            }
            // Get new FCM registration token
            val token = task.result

            Toast.makeText(baseContext, token, Toast.LENGTH_SHORT).show()
        })
    }
}
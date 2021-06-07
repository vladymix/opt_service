package com.ssr.otp.ui

import android.content.Intent
import android.os.Bundle
import android.os.Handler
import android.view.View
import androidx.recyclerview.widget.RecyclerView
import com.ssr.otp.BaseActivity
import com.ssr.otp.R
import com.ssr.otp.adapters.DeliveryAdapter
import com.ssr.otp.models.Delivery

class DeliveriesActivity : BaseActivity() {

    private val mAdapter = DeliveryAdapter { onItemSelected(it) }
    var callerApi = true

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_deliveries)
        findViewById<RecyclerView>(R.id.recicleView).adapter = mAdapter
        findViewById<View>(R.id.btnOnBack).setOnClickListener { this.onBackPressed() }
    }

    override fun onPause() {
        super.onPause()
        callerApi = false
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

    fun refreshData(){
        if(callerApi){
            Handler().postDelayed({
                mAdapter.setSource(appLogic.getDeliveries())
                refreshData()
            }, 2000)
        }

    }

    private fun onItemSelected(item: Delivery) {
        appLogic.itemSelected = item
        startActivity(Intent(this, LocationActivity::class.java))
    }
}
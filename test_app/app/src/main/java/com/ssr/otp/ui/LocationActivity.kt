package com.ssr.otp.ui

import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.core.content.ContextCompat
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.MarkerOptions
import com.ssr.otp.BaseActivity
import com.ssr.otp.Extentions.getColorStatus
import com.ssr.otp.Extentions.getImageStatus
import com.ssr.otp.Extentions.getStatusButton
import com.ssr.otp.R

class LocationActivity : BaseActivity() {

    private val callback = OnMapReadyCallback { googleMap ->
        val upm = LatLng(40.38955, -3.627098)
        googleMap.addMarker(MarkerOptions().position(upm).title("UPM"))
        googleMap.animateCamera(CameraUpdateFactory.newLatLngZoom(upm, 17.0f))
    }

    lateinit var imageStatus: ImageView
    lateinit var trackid: TextView
    lateinit var btnCode: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_location)

        findViewById<View>(R.id.btnOnBack).setOnClickListener { this.onBackPressed() }

        imageStatus = findViewById(R.id.imageStatus)
        trackid = findViewById(R.id.trackid)
        btnCode = findViewById(R.id.btnCode)

        val mapFragment =
            supportFragmentManager.findFragmentById(R.id.mapFragment) as SupportMapFragment
        mapFragment.getMapAsync(callback)

        btnCode.setOnClickListener {

            if( appLogic.itemSelected?.status == "1"){
                appLogic.itemSelected?.status = "2"
            }else{
                appLogic.itemSelected?.status = "1"
            }
            bindValues()
        }

        this.bindValues()
    }

    fun bindValues() {
        appLogic.itemSelected?.let {
            imageStatus.setImageResource(it.status.getImageStatus())
            trackid.text = it.trackId
            btnCode.setBackgroundColor(ContextCompat.getColor(this, it.status.getColorStatus()))
            btnCode.text = it.status.getStatusButton()
        }
    }
}
package com.ssr.otp

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity

open class BaseActivity: AppCompatActivity() {
    protected lateinit var appLogic:AppLogic
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        appLogic = AppLogic.getInstance(this)

    }
}
package com.ssr.otp

import android.annotation.SuppressLint
import android.content.Context
import com.ssr.otp.models.Delivery

class AppLogic private constructor(val context: Context) {

    companion object {
        @SuppressLint("StaticFieldLeak")
        private var instance: AppLogic? = null

        fun getInstance(context: Context): AppLogic {
            if (instance == null) {
                instance = AppLogic(context)
            }

            return instance!!
        }
    }


    var itemSelected: Delivery?=null
    private val mDeliveries: List<Delivery> by lazy {
        val list = ArrayList<Delivery>()
        list.add(Delivery("123HH4563","0"))
        list.add(Delivery("253F4SDKJ","0"))
        list.add(Delivery("33KJ32K2J","0"))
        list.add(Delivery("4923J2HJ2","0"))
        list.add(Delivery("53892NN2J","0"))
        list.add(Delivery("68382J2K3","0"))
        list.add(Delivery("789NN3M23","0"))
        list.add(Delivery("8434N3M23","0"))
        list.add(Delivery("9134N3M23","0"))
        list.add(Delivery("1019N3M23","0"))
        list.add(Delivery("1119N3M23","0"))
        list
    }

    fun getDeliveries() : List<Delivery> {
        return mDeliveries
    }


}
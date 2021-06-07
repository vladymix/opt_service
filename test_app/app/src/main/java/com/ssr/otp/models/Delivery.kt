package com.ssr.otp.models

data class Delivery (var trackId:String, var status:String,  var jwt_otp: String?=null)
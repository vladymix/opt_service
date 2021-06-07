package com.ssr.otp.models

data class LoginRequest (val email:String, val pass_hash:String)
data class LoginResponse(val jwt:String)

data class PushRequest(val email:String, val token_push:String)
data class PushResponse(val email:String, val status:String)

data class GenerateRequest (val token:String, val track_id:String, val email_cliente:String)
data class GenerateResponse (val jwt_otp:String, val track_id:String, val estado:String)

data class StatusRequest (val token:String, val jwt_otp:String, val id_tracker:String)
data class StatusClientRequest (val token:String,  val id_tracker:String)
data class StatusResponse (val id_tracker:String, val status:String)

data class ValidateRequest (val token:String, val track_id:String, val otp_pass:String)
data class ValidateResponse (val id_tracker:String, val status:String)
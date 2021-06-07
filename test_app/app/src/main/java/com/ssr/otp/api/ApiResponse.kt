package com.ssr.otp.api

interface ApiResponse<T> {
    fun apiResult(data:T)
    fun apiError(error:String?)
}
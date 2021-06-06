package com.ssr.otp

object Extentions {

    fun String.getStatusName(): String {
        return when (this) {
            "1" -> "Confirmation wait"
            "2" -> "Confirmed"
            else -> "On delivery"
        }
    }

    fun String.getStatusButton(): String {
        return when (this) {
            "1" -> "Confirmation wait"
            "2" -> "Confirmed"
            else -> "Generate code"
        }
    }

    fun String.getImageStatus(): Int {
        return when (this) {
            "1" -> R.drawable.ic_open_box
            "2" -> R.drawable.ic_closed_box
            else -> R.drawable.ic_open_box
        }
    }

    fun String.getColorStatus(): Int {
        return when (this) {
            "1" -> R.color.color_wait
            "2" -> R.color.color_entregado
            else -> R.color.color_generate_code
        }
    }
}
package com.ssr.otp.dialogs

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.TextView
import androidx.core.content.ContextCompat
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.ssr.otp.R

class SheetDialogValidate: BottomSheetDialogFragment() {

    var mMessage:String?=null
    var mTitle:String? = null
    var color:Int = R.color.color_wait

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        return inflater.inflate(R.layout.layout_sheet_dialog, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        view.findViewById<TextView>(R.id.tvTitle)?.text = mTitle?:"Otp App"
        view.findViewById<TextView>(R.id.tvTitle)?.setTextColor(ContextCompat.getColor(view.context, color))
        view.findViewById<TextView>(R.id.tvMessage)?.text = mMessage?:"Message"
        view.findViewById<View>(R.id.btnOk).setOnClickListener { this.dismiss() }
        view.findViewById<Button>(R.id.btnOk).setBackgroundColor(ContextCompat.getColor(view.context, color))
    }


}
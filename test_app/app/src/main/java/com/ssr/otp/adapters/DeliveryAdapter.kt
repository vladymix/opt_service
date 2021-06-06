package com.ssr.otp.adapters

import android.content.res.ColorStateList
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.cardview.widget.CardView
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.RecyclerView
import com.altamirano.fabricio.libraryast.tools.inflate
import com.ssr.otp.Extentions.getColorStatus
import com.ssr.otp.Extentions.getImageStatus
import com.ssr.otp.Extentions.getStatusName
import com.ssr.otp.R
import com.ssr.otp.models.Delivery

class DeliveryAdapter(var itemSelected: (Delivery) -> Any) :
    RecyclerView.Adapter<DeliveryAdapter.DeliveryHolder>() {

    private var source = ArrayList<Delivery>()

    inner class DeliveryHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {

        val trackid = itemView.findViewById<TextView>(R.id.trackid)
        val statusColor = itemView.findViewById<CardView>(R.id.statusColor)
        val statusName = itemView.findViewById<TextView>(R.id.statusName)
        val imageStatus = itemView.findViewById<ImageView>(R.id.imageStatus)

        fun bind(item: Delivery) {
            itemView.setOnClickListener {
                itemSelected.invoke(source[adapterPosition])
            }
            trackid.text = item.trackId
            statusName.text = item.status.getStatusName()
            imageStatus.setImageResource(item.status.getImageStatus())
            statusColor.setCardBackgroundColor(ColorStateList.valueOf(ContextCompat.getColor(statusColor.context, item.status.getColorStatus())))
        }

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): DeliveryHolder {
        return DeliveryHolder(parent.inflate(R.layout.item_delivery))
    }

    override fun onBindViewHolder(holder: DeliveryHolder, position: Int) {
        holder.bind(source[position])
    }

    override fun getItemCount(): Int {
        return source.size
    }

    fun setSource(deliveries: List<Delivery>) {
        source.clear()
        source.addAll(deliveries)
        notifyDataSetChanged()
    }
}
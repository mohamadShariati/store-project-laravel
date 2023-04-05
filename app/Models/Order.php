<?php

namespace App\Models;

use App\Models\User;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='orders';
    protected $guarded = [];

    public function getStatusAttribute($payment_status)
    {
        return $payment_status ? 'پرداخت شده' : 'در انتظار پرداخت  ';
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getPaymentTypeAttribute($paymentType)
    {
        switch($paymentType){
            case 'pos' :
                $paymentType = 'دستگاه pos';
                break;
            case 'online' :
                $paymentType = 'اینترنتی';
                break;
        }
        return $paymentType;
    }

    public function getPaymentStatusAttribute($paymentStatus)
    {
        switch($paymentStatus){
            case '0' :
                $paymentStatus = 'ناموفق';
                break;
            case '1' :
                $paymentStatus = 'موفق';
                break;
        }
        return $paymentStatus;
    }

    // public function coupon($couponId)
    // {
    //     return Coupon::where('id',$couponId)->first()->name ;
    // }
}

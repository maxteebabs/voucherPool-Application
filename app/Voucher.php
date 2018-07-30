<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = array('special_offer_id', 'percentage_discount', 'vouchers'
        , 'usage', 'expiry_date', 'usage_date');
    public function specialOffer() {
        return $this->belongsTo('App\SpecialOffer', 'special_offer_id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}

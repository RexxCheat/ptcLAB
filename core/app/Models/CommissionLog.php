<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    protected $guarded = ['id'];

    public function userTo(){
    	return $this->belongsTo(User::class,'to_id');
    }

    public function userFrom(){
    	return $this->belongsTo(User::class,'from_id');
    }
}

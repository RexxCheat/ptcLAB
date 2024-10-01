<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtcView extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function ptc()
    {
        return $this->belongsTo(Ptc::class);
    }
}

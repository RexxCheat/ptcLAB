<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $casts = [
        'withdraw_information' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function method()
    {
        return $this->belongsTo(WithdrawMethod::class, 'method_id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';
        if($this->status == 2){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }elseif($this->status == 1){
            $html = '<span><span class="badge badge--success">'.trans('Approved').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }elseif($this->status == 3){
            $html = '<span><span class="badge badge--danger">'.trans('Rejected').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }
        return $html;
    }

    public function scopePending()
    {
        return $this->where('status', 2);
    }

    public function scopeApproved()
    {
        return $this->where('status', 1);
    }

    public function scopeRejected()
    {
        return $this->where('status', 3);
    }
}

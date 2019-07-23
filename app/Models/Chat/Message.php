<?php

namespace App\Models\Chat;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body'
    ];

    protected $appends = ['owner'];

    public function getOwnerAttribute()
    {
        return $this->user_id == auth()->user()->id;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/y H:i');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

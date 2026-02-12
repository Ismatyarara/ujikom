<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;

      protected $table = 'ch_messages'; // WAJIB

    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, 'from_id');
    }

    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'to_id');
    }

      public function from_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'from_id');
    }

    public function to_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'to_id');
    }
}
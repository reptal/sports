<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $hidden
      = [
        'created_at',
        'updated_at',
        'user_id',
      ];

    //user relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //players
    public function players()
    {
        return $this->hasMany(Player::class);

    }
}

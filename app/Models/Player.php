<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    protected $hidden
      = [
        'created_at',
        'updated_at',
      ];
    //team
    public function team()
    {
        return $this->belongsTo(Team::class);

    }
}

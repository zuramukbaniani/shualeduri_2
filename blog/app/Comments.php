<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        "post_id", "comment", "post_own_id", "user_id", "username"
    ];
}

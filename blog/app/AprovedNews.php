<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AprovedNews extends Model
{
    protected $fillable = [
        "team_id", "league_id", "title", "short_description", "description", "image", "user_id", "username"
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentsReply extends Model
{
    protected $fillable = [
        "post_id", "comment", "post_own_id", "user_id", "username", "comment_id", "mather_comment_id"
    ];
}

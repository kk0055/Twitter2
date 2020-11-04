<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getComments(Int $tweet_id)
    {
        //withで関連するuserも取得
        return $this->with('user')->where('tweet_id',$tweet_id)->get();
    }

    //tweetにbelongsToはいらないのか？
}

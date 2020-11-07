<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;

     // いいねしているかどうかの判定
    public function isFavorite(Int $user_id, Int $tweet_id)
    {
       return (boolean) $this->where('user_id',$user_id)->where('tweet_id',$tweet_id)->first();

    }

    //イイネを保存
    public function storeFavorite(Int $user_id, Int $tweet_id)
    {
       //どこのthis? これはどういう動き?
       $this->user_id = $user_id; 
       $this->tweet_id = $tweet_id; 
       $this->save();
    }

     //イイネを保存
     public function destroyFavorite(Int $favorite_id)
     {
        return $this->where('id',$favorite_id)->delete();
     }
     //tweetにbelongsToはいらないのか？

}

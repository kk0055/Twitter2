<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Tweet extends Model
{
    use HasFactory;
    use softDeletes;
    
    
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //ツイート取得
    public function getUserTimeLine(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);

    }

     //ツイート数取得
    public function getTweetCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    //Follower ModelのfollowingIds（）で取得したフォローしているユーザIDをControllerを介して取得してそのデータを引数で渡す
    public function getTimeLines(Int $user_id, Array $follow_ids)
    {
        // 自身とフォローしているユーザIDを結合する
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id', $follow_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }

    public function getTweet(Int $tweet_id)
    {
        //withで関連するuserも取得
        return $this->with('user')->where('id',$tweet_id)->first();
    }

    public function tweetStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->text = $data['text'];
        $this->save();

        return;
    }
  //$user_idと$tweet_idの値の一致するツイートを取得
  //$tweet_idは$idに変えてもうごく
    public function getEditTweet(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->first();
    }

    public function tweetUpdate(Int $tweet_id, Array $data)
    {
        $this->id = $tweet_id;
        $this->text = $data['text'];
        $this->update();

        return;
    }

    //$user_id消しても問題ない
    public function tweetDestroy($user_id,$tweet_id)
    {
        return $this->where('user_id',$user_id)->where('id',$tweet_id)->delete();
    }
}

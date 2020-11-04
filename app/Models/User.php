<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'screen_name',
        'profile_image',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //following_idでUserと紐づけ。followerを取得
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

     //followed_idでUserと紐づけ
    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    //引数で受け取ったuserを除くユーザを取得。5人でpaginate
    public function getAllUsers(Int $user_id)
    {
    return $this->where('id', '<>',$user_id)->simplePaginate(5);
    }

    //フォローする followsメソッドにuser_idをつける
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }
    //フォロー解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }
    
    // フォローしているか.followsメソッドのfollowed_idがuser_idと一致する1番目のidを返す
    public function isFollowing(Int $user_id) 
    {
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    // フォローされているか
    public function isFollowed(Int $user_id) 
    {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }
   
    public function updateProfile(Array $params)
    {
     if (isset($params['profile_image'])) {
        $file_name = $params['profile_image']->store('public/profile_image/');
        $this::where('id', $this->id)
          ->update([
            'screen_name'   => $params['screen_name'],
            'name'          => $params['name'],
            'profile_image' => basename($file_name),
            'email'         => $params['email'],
        ]);
     }else {
        $this::where('id', $this->id)
            ->update([
                'screen_name'   => $params['screen_name'],
                'name'          => $params['name'],
                'email'         => $params['email'],
            ]); 
    }

    return ;
    }
}

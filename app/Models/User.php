<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class,'user_id');
    }

    public function profileLatest()
    {
        /*
         طريقة استخدام اخر للتابع
        */

        //return $this->hasOne(Rent::class)->latestOfMany('created_at')->where('status', 'active');
        return $this->hasOne(Profile::class,'user_id')->latestOfMany();
    }

    public function profileFilter()
    {
        return $this->hasOne(Profile::class,'user_id')->ofMany('id', 'max');
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Profile::class);
    }

    public function hasOneThroughPosts()
    {
        return $this->hasOneThrough(Post::class, Profile::class);
    }

    //many to many
    /*
     * withPivot for add name columns we want return in relation
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_user')->withPivot('status');
    }


    public function roles()
    {
        /*
            withTimestamps() بترجع قيم عامود الاضافة والتعديل
      */

        return $this->belongsToMany(Role::class,'role_users')->withTimestamps();
    }

    public function follows()
    {
        // ارجاع كل شخص يتابعه المستخدم
        return $this->belongsToMany(self::class, 'followers', 'user_id','follows_id', )
            ->withPivot(['id']);
    }

    public function followers()
    {
        //الاشخاص التي تتابع اليوزر
        return $this->belongsToMany(self::class, 'followers', 'follows_id', 'user_id')

            ->withPivot(['follows_id', 'user_id']);
    }

    public function follow($userId)
    {
        $this->follows()->attach($userId);
        return $this;
    }

    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        /*
       ايدي $userId تفحص هل المستخدم الحالي يتابع المستخدم صاحب
        */
        return (boolean) $this->follows()->where('follows_id', $userId)->first(['followers.id']);
    }
}

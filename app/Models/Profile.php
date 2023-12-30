<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ["pofileInfo"];

    public function posts()
    {
        return $this->hasMany(Post::class,'profile_id');
    }
    //many to many
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // dont work
    public function latestPost()
    {
        return $this->hasMany(Post::class,'profile_id')->latestOfMany();
    }
}

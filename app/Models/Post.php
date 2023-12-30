<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
/*
 * return just one image for one post
 * if post have many images it will return just one image
 */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /*
     * if post have many images
     * this function latestOfMany return last&one image
     */
    public function latestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }

    /*
     * return many images for one post
     */
        public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    //dont work
    public function manyImages()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    //dont work
    public function imageLatest()
    {
        return $this->images()->latest()->first()->get();
    }

    //many to many morph
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }
}

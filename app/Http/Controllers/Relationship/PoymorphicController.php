<?php

namespace App\Http\Controllers\Relationship;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoymorphicController extends Controller
{
    public function O2O()
    {
        $post = Post::find(1);
        $image = $post->image;

        return response()->json(["data" => $image]);
    }

    public function latestImage()
    {
        $post = Post::find(1);
        $imagesLatest = $post->latestImage;

        return response()->json(["data" => $imagesLatest]);
    }

    public function PostImages()
    {
        $post = Post::find(1);
        $images = $post->images()->get();
// or  $images = $post->images;
        return response()->json(["data" => $images]);
    }

    public function manyImages()
    {
        $post = Post::find(1);
        $images = $post->manyImages;

        return response()->json(["data" => $images]);
    }

    //last image has been added
    public function imageLatest()
    {
        $post = Post::find(1)->images()->latest()->first();
       //# $post = Post::find(1)->imageLatest;

        return response()->json(["data" => $post]);
    }

    public function userProfile()
    {
        // or $user = User::find(1)->profile->pofileInfo;
        $user = User::find(1)->profile;
        return response()->json(["data" => $user]);
    }

    public function createUserProfile()
    {
        $user = User::find(1);

        $profile = $user->profile()->create([
         'pofileInfo' => "pofileInfo 2"
        ]);

        return response()->json(["data" => $profile]);
    }

    public function profilePosts()
    {
        $titles = [];

        $profiles = Profile::find(1)->posts;

        foreach ($profiles as $profile) {
            $titles[] = $profile->title;
    }
        return response()->json(["data" => $titles]);
    }

    public function latestPosts()
    {
        //return posts from newest to oldest
       // $lastPost = Profile::find(1)->posts()->latest()->get();

        //return just last post has been added
        $lastPost = Profile::find(1)->posts()->latest()->first();

        // dont work
       // $lastPost = Profile::find(1)->latestPost;

        return response()->json(["data" => $lastPost]);
    }

    public function userPosts()
    {
        $user = User::with('profile','posts')->where('id',1)->get();

        return response()->json(["data" => $user]);
    }

    //dont work
    public function craeteTagsforPost()
    {
        $post1 = Post::find(1);

        $tag = new Tag;
        $tag->name = "Madona";

        $post1->tags()->save($tag);

//        $post = Post::find(1)->tags()->create([
//            "name" => "Laravel",
//
//        ]);


//
//        $tag1 = new Tag;
//        $tag1->name = "Laravel";
//
//        $tag2 = new Tag;
//        $tag2->name = "jQuery";
//
//        $post->tags()->saveMany([$tag1, $tag2]);
        return response()->json(["data" => $post]);
    }

    //dont work
    public function getTags()
    {
        $post = Post::find(1);

        $tag1 = Tag::find(1);
        $tag2 = Tag::find(2);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        /*$post = Post::find(1);
        $tags = $post->tags;
        */

        return response()->json(["data" => $post]);
    }

    public function getDataFromPivot()
    {
        $activeArray = [];
        $user = User::find(1);
       /* $profile1 = Profile::find(1);
        $profile2 = Profile::find(2);

        $user->profiles()->attach([$profile1->id, $profile2->id])*/
        foreach ($user->profiles as $profile) {
            $activeArray[] = $profile->pivot->status;
        }

        return response()->json(["data" => $activeArray]);
    }

    public function getProfileUser()
    {
        $profile = User::find(1)->profileLatest;

        return response()->json(["data" => $profile]);
    }

    public function getProfileUserFilter()
    {
        $profileFilter = User::find(1)->profileFilter;

        return response()->json(["data" => $profileFilter]);
    }

    public function hasOneThroughPosts()
    {
        $hasOneThroughPosts = User::find(1)->hasOneThroughPosts;

        return response()->json(["data" => $hasOneThroughPosts]);
    }

    public function m2m()
    {
        $user = User::find(1)->roles()->orderBy('name')->where('name', 'admin')->get();

        return response()->json(["data" => $user]);
    }

}

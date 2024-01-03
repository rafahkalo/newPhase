<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function getAllFollower($userId)
    {
        // ارجاع كل شخص يتابعه المستخدم

        $followes = User::find($userId)->follows;
        //dd($followes);

        return response()->json(['data'=>$followes]);
    }

    public function getFollwers()
    {
        //الاشخاص التي تتابع اليوزر
        $user = User::find(1);
        $followers = $user->followers;

        return response()->json(['data' => $followers]);
    }

    public function index1()
    {
        //ارجاع كل المستخدمين من عدا الشخص يلي مسجل دخول

        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('users.index', compact('users'));
    }

    /*
     * not more speed
     * public function follow(User $user)
    {
        $follower = auth()->user();

        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }

        if (!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification asynchronously
            Notification::send($user, new UserFollowed($follower, $user));

            return back()->withSuccess("You are now friends with {$user->name}");
        }

        return back()->withError("You are already following {$user->name}");
    }*/

   public function follow(User $user)
    {
        $follower = auth()->user();
        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }
        if(!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification
            $user->notify(new UserFollowed($follower, $user));

            return back()->withSuccess("You are now friends with {$user->name}");
        }

        return back()->withError("You are already following {$user->name}");
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if($follower->isFollowing($user->id)) {
            $follower->unfollow($user->id);
            return back()->withSuccess("You are no longer friends with {$user->name}");
        }
        return back()->withError("You are not following {$user->name}");
    }

    public function showingNotifications()
    {
        $user = User::find(3);

        if ($user) {
            if ($user->unreadNotifications->isNotEmpty()) {
                foreach ($user->unreadNotifications as $notification) {
                    echo $notification->data['follower_name']. ' Is Follow You';
                }
            } else {
                echo "No unread notifications.";
            }
        } else {
            echo "User not authenticated.";
        }
    }
    public function makeNotificationAsRead()
    {
        $user = User::find(3);

        if ($user) {
            $user->unreadNotifications->markAsRead();
            echo "All notifications marked as read.";
        } else {
            echo "User not authenticated.";
        }

    }
}

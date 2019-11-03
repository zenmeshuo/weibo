<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取所有用户
        $users = User::all();
        // 取出第一个用户,记录id
        $user = $users->first();
        $user_id = $user->id;

        // 获取去除第一个用户id的所有用户id数组
        $followers = $users->slice($user_id);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除了第一个用户以外的所有用户
        $user->follow($follower_ids);

        // 除了第一个用户以外的所有用户都来关注第一个用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}

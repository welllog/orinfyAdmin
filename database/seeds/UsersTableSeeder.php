<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        $users = factory(\App\Models\User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index) {
                $user->mobile = '18654' . mt_rand(100000, 999999);
            });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        \App\Models\User::insert($user_array);
    }
}

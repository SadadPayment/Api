<?php

use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new App\Model\UserGroup();
        $group->type = "Admin";
        $group->save();

        $group = new App\Model\UserGroup();
        $group->type = "Agent";
        $group->save();

        $group = new App\Model\UserGroup();
        $group->type = "user";
        $group->save();

        $group = new App\Model\UserGroup();
        $group->type = "user_vip";
        $group->save();

        $group = new App\Model\UserGroup();
        $group->type = "user_plat";
        $group->save();
        //
//        factory(App\Model\UserGroup::class , 3)->create();
    }
}

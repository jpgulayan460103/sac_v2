<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserNameRefactor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->first_name = $user->name;
            $user->save();
        }
    }
}

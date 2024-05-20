<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user  =  new User();

        $user->name      = "Nazmul Hassan";
        $user->email     = "hnazmul748@gmail.com";
        $user->password  = Hash::make("147852369");
        $user->role      = 3;
        $user->status    = 1;

        $user->save();
    }
}

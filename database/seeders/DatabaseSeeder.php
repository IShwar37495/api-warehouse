<?php

namespace Database\Seeders;

use App\Models\Api;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    //   Api::factory(10)->create();

     Role::create([
        'name'=>'Admin'
      ]);

      Role::create([
        'name'=>'User'
      ]);


     $user= User::create([
        'name'=>'Admin',
        'email'=>'ishwarjhokhra2000@gmail.com',
        'password'=>Hash::make('password@123'),
        'client_id'=>Str::uuid(),
        'email_verified_at'=>now(),

      ]);

    $token = $user->createToken('Admin Token')->plainTextToken;

      $user->assignRole('admin');




    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
   /**
    * Run the database seeds.
   */
   public function run(): void
   {
      User::create([
          'email' => 'simon@mail.mail',
          'password' => bcrypt('password'),
          'nickname' => 'simon'
      ]);

      /*User::factory(7)->create()-> each(function($user) {

         $user -> assignRole('player');

      });*/

      User::factory(5)->create();


   }


}

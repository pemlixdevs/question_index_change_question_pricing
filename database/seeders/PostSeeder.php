<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i =1; $i<=20; $i++){
            Post::create([
            'title' =>  'Test post title '.$i,
            'status' =>  rand(0, 1),
            'position' =>  $i,
            'description' =>  'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio ratione eius qui',
            ]);
        }
    }
}

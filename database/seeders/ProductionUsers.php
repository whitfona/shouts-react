<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProductionUsers extends Seeder
{
    /**
     * Run the database Users seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Nick',
            'email' => 'whitford_4@hotmail.com',
            'password' => '$2y$10$6QPWEneMpsKh6ZdjYofzbuzU7oNGHKDfkHbzkLAFwpQJypumTjWJ6'
        ]);
        User::factory()->create([
            'name' => 'Firas Khalid',
            'email' => 'drfiraskhalid@gmail.com',
            'password' => '$2y$10$mwnVU3CofQOvQ1BIQjmjV.ZyKqpu/97DXBMa6O80nn/0FH8kmix76'
        ]);
        User::factory()->create([
            'name' => 'Jill',
            'email' => 'jillian.halladay@hotmail.com',
            'password' => '$2y$10$/a/6e1lBWX5T6aiW7YDXTeDIiKEdhlQ8UazPv9Z8AiWUWRIZXER7q'
        ]);
        User::factory()->create([
            'name' => 'Ivan',
            'email' => 'riverinyo@gmail.com',
            'password' => '$2y$10$M/OosN27SXKAFtRG47QC4eLR3iWmRhFNTspmqf8Hzbswg.maau97e'
        ]);
        User::factory()->create([
            'name' => 'Josh Hillman',
            'email' => 'joshhillman@simplyanchored.ca',
            'password' => '$2y$10$QEx30V1oQ1/3aiPS.XaMYOUMeiyl0xZNe2UtD69fP4lREBMDS/sEK'
        ]);
        User::factory()->create([
            'name' => 'Andy J',
            'email' => 'andyjlloyd@gmail.com',
            'password' => '$2y$10$KtYOjYvxeYsnmfe2QG83dugomCPmfRSklmWZAeDX/t4qpSOftnjbW'
        ]);
        User::factory()->create([
            'name' => 'Moniefa',
            'email' => 'moniefae@yahoo.ca',
            'password' => '$2y$10$5eqPGmwLyu33bY259PJsHulvwzIyCswFVh4B.xZf5ZTHVW58cTwMC'
        ]);
        User::factory()->create([
            'name' => 'Gideon Bell',
            'email' => 'bell.gideon@gmail.com',
            'password' => '$2y$10$dz7j/3098SsYiOSwvDgcyuNWKu7gj/cCAtS6WJr7qiYU9sGDPTEVS'
        ]);
    }
}

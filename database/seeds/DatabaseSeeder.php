<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $set = factory(\App\Set::class)->create();
        $draft = factory(\App\Draft::class)->create([
            'set_id' => $set->id
        ]);
        factory(\App\Card::class, 50)->create([
            'set_id' => $set->id
        ]);
        factory(\App\Player::class, 5)->create([
            'draft_id' => $draft->id
        ]);
    }
}

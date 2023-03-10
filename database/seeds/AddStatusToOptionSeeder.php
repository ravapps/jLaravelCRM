<?php

use App\Models\Option;
use Illuminate\Database\Seeder;

class AddStatusToOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        //status options
        Option::create([
            'category' => 'status',
            'title' => 'Not Started',
            'value' => 'Not Started',
        ]);
        Option::create([
            'category' => 'status',
            'title' => 'In Progress',
            'value' => 'In Progress',
        ]);
        Option::create([
            'category' => 'status',
            'title' => 'Completed',
            'value' => 'Completed',
        ]);
        Option::create([
            'category' => 'status',
            'title' => 'Pending',
            'value' => 'Pending',
        ]);
        Eloquent::reguard();
    }
}

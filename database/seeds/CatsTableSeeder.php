<?php

use Illuminate\Database\Seeder;
use App\Cats\Model\Cat;

/**
 * Class CatsTableSeeder
 */
class CatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = factory(Cat::class, 10)->create();
    }
}

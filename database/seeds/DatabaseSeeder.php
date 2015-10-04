<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Beer;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(BeersTableSeeder::class);

        Model::reguard();
    }
}

class BeersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('beers')->delete();

        Beer::create(['brand' => 'Labatt', 'name' => 'Blue', 'style' => 'Dry', 'percent' => '4.1', 'slug' => 'blue']);
        Beer::create(['brand' => 'Alexandre Keith', 'name' => 'Keith', 'style' => 'Red', 'percent' => '5.5', 'slug' => 'keith']);
        Beer::create(['brand' => 'Coors', 'name' => 'Coorslight', 'style' => 'Light', 'percent' => '4.5', 'slug' => 'coorslight']);

        $this->command->info('Beers table seeded!');
    }

}
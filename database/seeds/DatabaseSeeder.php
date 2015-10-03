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

        Beer::create(['name' => 'Budlight', 'style' => 'Light', 'percent' => '4.1', 'brand' => 'Budlight', 'slug' => 'Budlight']);
        Beer::create(['name' => 'Keith', 'style' => 'Red', 'percent' => '5.5', 'brand' => 'Budlight', 'slug' => 'Keith']);
        Beer::create(['name' => 'Coorslight', 'style' => 'Light', 'percent' => '4.5', 'brand' => 'Budlight', 'slug' => 'Coorslight']);

        $this->command->info('Beers table seeded!');
    }

}
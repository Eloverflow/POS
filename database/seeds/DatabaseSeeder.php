<?php

use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\ERP\ItemTypes\ItemTypeBeer;
use App\Models\ERP\ItemTypes\ItemTypeDrink;
use App\Models\ERP\Supplier;
use App\Models\ERP\Order;
use App\Models\ERP\Inventory;
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
        $this->call(SuppliersTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ItemTypesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ItemTypeBeersTableSeeder::class);
        $this->call(ItemTypeDrinksTableSeeder::class);
        $this->call(InventoriesTableSeeder::class);

        Model::reguard();
    }
}

class SuppliersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('suppliers')->delete();

        Supplier::create(['name' => 'Labatt', 'slug' => 'labatt']);
        Supplier::create(['name' => 'Alexandre Keith', 'slug' => 'alexandre_keith']);

        $this->command->info('Suppliers table seeded!');
    }

}

class OrdersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('orders')->delete();

        Order::create(['supplier_id' => '1', 'command_number' => '1000141']);
        Order::create(['supplier_id' => '1', 'command_number' => '1000148']);

        $this->command->info('Orders table seeded!');
    }

}

class ItemTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_types')->delete();

        ItemType::create(['type' => 'Beer', 'slug' => 'beer']);
        ItemType::create(['type' => 'Drink', 'slug' => 'drink']);

        $this->command->info('ItemTypes table seeded!');
    }

}

class ItemsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('items')->delete();

        Item::create(['item_type_id' => '1', 'name' => 'Keith', 'slug' => 'keith']);
        Item::create(['item_type_id' => '1', 'name' => 'Blue', 'slug' => 'blue']);

        $this->command->info('Items table seeded!');
    }

}

class ItemTypeBeersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_type_beers')->delete();

        ItemTypeBeer::create(['item_type_id' => '1', 'brand' => 'Alexander Keith', 'style' => 'Red', 'percent' => '5.5']);
        ItemTypeBeer::create(['item_type_id' => '1', 'brand' => 'Labatt', 'style' => 'Dry', 'percent' => '5.9']);

        $this->command->info('ItemTypeBeers table seeded!');
    }

}



class ItemTypeDrinksTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_type_drinks')->delete();

        ItemTypeDrink::create(['item_type_id' => '2', 'style' => 'Lux', 'flavour' => 'Spicy', 'author' => 'Jino']);
        ItemTypeDrink::create(['item_type_id' => '2', 'style' => 'Hangover', 'flavour' => 'Sour', 'author' => 'Jino']);

        $this->command->info('ItemTypeDrinks table seeded!');
    }

}

class InventoriesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('inventories')->delete();

        Inventory::create(['order_id' => '1', 'item_id' => '1', 'quantity' => '100']);
        Inventory::create(['order_id' => '1', 'item_id' => '2', 'quantity' => '50']);

        $this->command->info('Inventories table seeded!');
    }

}
<?php

use App\Models\ERP\Item;
use App\Models\ERP\ItemFieldList;
use App\Models\ERP\ItemType;
use App\Models\ERP\Supplier;
use App\Models\ERP\Order;
use App\Models\ERP\Inventory;
use App\Models\Addons\Rfid\TableRfid;
use App\Models\Addons\Rfid\TableRfidRequest;
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
        $this->call(ItemFieldListsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        //$this->call(ItemTypeBeersTableSeeder::class);
        //$this->call(ItemTypeDrinksTableSeeder::class);
        $this->call(InventoriesTableSeeder::class);
        $this->call(RfidTableSeeder::class);
        $this->call(RfidTableRequestSeeder::class);

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

        ItemType::create(['type' => 'Beer', 'fields_names' => 'brand,style,percent ', 'slug' => 'beer']);
        ItemType::create(['type' => 'Drink', 'fields_names' => 'flavour,color,author,percent', 'slug' => 'drink']);

        $this->command->info('ItemTypes table seeded!');
    }

}


class ItemFieldListsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_field_lists')->delete();

        /*One for each item | this is an extention to have custum field for every type of item*/
        /*Every fiel could lead to a list of sugguestion by doing a select with the ItemType fields_names*/
        ItemFieldList::create(['field1' => 'Alexander Keith', 'field2' => 'Red', 'field3' => '5']);
        ItemFieldList::create(['field1' => 'Labatt', 'field2' => 'Dry', 'field3' => '5.6']);
        ItemFieldList::create(['field1' => 'Coors', 'field2' => 'Light', 'field3' => '4.5']);
        ItemFieldList::create(['field1' => 'Sour', 'field2' => 'green', 'field3' => 'Jino', 'field4' => '20']);

        $this->command->info('ItemFieldLists table seeded!');
    }

}


class ItemsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('items')->delete();

        /* The item type will define their item_field_name  */
        Item::create(['item_type_id' => '1', 'item_field_list_id' => '1', 'name' => 'Keith', 'slug' => 'keith']);
        Item::create(['item_type_id' => '1', 'item_field_list_id' => '2', 'name' => 'Blue', 'slug' => 'blue']);
        Item::create(['item_type_id' => '1', 'item_field_list_id' => '3', 'name' => 'Coorslight', 'slug' => 'coorslight']);
        Item::create(['item_type_id' => '2', 'item_field_list_id' => '4', 'name' => 'MyDrinkName', 'slug' => 'mydrinkname']);

        $this->command->info('Items table seeded!');
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

class RfidTableSeeder extends Seeder {

    public function run()
    {
        DB::table('rfid_tables')->delete();

        TableRfid::create(['flash_card_hw_code' => '1', 'name' => 'Poste 1', 'description' => '100']);
        TableRfid::create(['flash_card_hw_code' => '2', 'name' => 'Poste 2', 'description' => '50']);

        $this->command->info('rfid_tables table seeded!');
    }

}

class RfidTableRequestSeeder extends Seeder {

    public function run()
    {
        DB::table('rfid_table_requests')->delete();

        TableRfidRequest::create(['id' => '1', 'flash_card_hw_code' => '1', 'rfid_card_code' => 'ad1213213']);

        $this->command->info('rfid_table_requests table seeded!');
    }

}
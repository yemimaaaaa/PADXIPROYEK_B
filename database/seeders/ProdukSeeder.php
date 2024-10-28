<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        if (DB::table('produk')->count() === 0) {
            DB::table('produk')->insert([
                [
                    'id_produk' => 2001, 
                    'nama_produk' => 'Espresso',          
                    'jenis_produk' => 'Minuman', 
                    'harga' => 18000.00, 
                    'deskripsi_produk' => 'Espresso shot',             
                    'foto_produk' => 'espresso.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2002, 
                    'nama_produk' => 'Americano',         
                    'jenis_produk' => 'Minuman', 
                    'harga' => 20000.00, 
                    'deskripsi_produk' => 'Americano coffee',          
                    'foto_produk' => 'americano.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2003, 
                    'nama_produk' => 'Latte',             
                    'jenis_produk' => 'Minuman', 
                    'harga' => 25000.00, 
                    'deskripsi_produk' => 'Creamy latte',             
                    'foto_produk' => 'latte.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2004, 
                    'nama_produk' => 'Cappuccino',        
                    'jenis_produk' => 'Minuman',
                    'harga' => 27000.00, 
                    'deskripsi_produk' => 'Classic cappuccino',        
                    'foto_produk' => 'cappuccino.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2005, 
                    'nama_produk' => 'Mocha',             
                    'jenis_produk' => 'Minuman', 
                    'harga' => 30000.00, 
                    'deskripsi_produk' => 'Chocolate-flavored coffee', 
                    'foto_produk' => 'mocha.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2006, 
                    'nama_produk' => 'Iced Coffee',       
                    'jenis_produk' => 'Minuman', 
                    'harga' => 22000.00, 
                    'deskripsi_produk' => 'Cold brewed iced coffee',  
                    'foto_produk' => 'iced_coffee.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2007, 
                    'nama_produk' => 'Caramel Macchiato', 
                    'jenis_produk' => 'Minuman', 
                    'harga' => 32000.00, 
                    'deskripsi_produk' => 'Caramel-flavored coffee',   
                    'foto_produk' => 'caramel_macchiato.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2008, 
                    'nama_produk' => 'Matcha Latte',      
                    'jenis_produk' => 'Minuman', 
                    'harga' => 28000.00, 
                    'deskripsi_produk' => 'Green tea latte',           
                    'foto_produk' => 'matcha_latte.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2009, 
                    'nama_produk' => 'Croissant',         
                    'jenis_produk' => 'Makanan', 
                    'harga' => 15000.00, 
                    'deskripsi_produk' => 'Buttery croissant',         
                    'foto_produk' => 'croissant.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'id_produk' => 2010, 
                    'nama_produk' => 'Cheesecake',        
                    'jenis_produk' => 'Makanan', 
                    'harga' => 35000.00, 
                    'deskripsi_produk' => 'Creamy cheesecake',         
                    'foto_produk' => 'cheesecake.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
            ]);
        }
    }
}
<?php

use Illuminate\Database\Seeder;
use App\mDirektorat;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(DirektoratSeeder::class);
    	$this->call(JabatanSeeder::class);
    	$this->call(StatusDokumenSeeder::class);
    	$this->call(StatusTujuanDokumenSeeder::class);
    	$this->call(UnitSeeder::class);
    	$this->call(SuperAdminSeeder::class);
    	$this->call(SuperSekdirSeeder::class);
    	$this->call(TipeDokumenSeeder::class);
    	$this->call(UserSeeder::class);
    }
}

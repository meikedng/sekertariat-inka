<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin Role
        $suRole = new Role();
        $suRole->name = "superuser";
        $suRole->display_name = "Super User";
        $suRole->save();

        $user = new User();
        $user->name = "Agri Kridanto";
        $user->nip = "991700051";
        $user->email = "agri.kridanto@inka.co.id";
        $user->password = bcrypt('rahasia');
        $user->jabatan_id = 1;
        $user->divisi_id = 1;
        $user->save();        
        $user->attachRole($suRole);
    }
}

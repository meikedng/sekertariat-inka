<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\mSekdir;

class SuperSekdirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Seksdirut Role
        $sekDirutRole = new Role();
        $sekDirutRole->name = "sek_dirut";
        $sekDirutRole->display_name = "Sekretaris Direktur Utama";
        $sekDirutRole->save();

        $user_sek_dirut = new User();
        $user_sek_dirut->name = "Sekretaris Dirut";
        $user_sek_dirut->nip = "sekt_dirut";
        $user_sek_dirut->email = "sekt_dirut@inka.co.id";
        $user_sek_dirut->password = bcrypt('rahasia');
        $user_sek_dirut->jabatan_id = 1;
        $user_sek_dirut->divisi_id = 1;
        $user_sek_dirut->save();        
        $user_sek_dirut->attachRole($sekDirutRole);

        $sekdir = new mSekdir();
        $sekdir->user_id = $user_sek_dirut->id;
        $sekdir->direksi_id = 1; // lihat master direksi 
        $sekdir->is_active = 1;
        $sekdir->save();

        // sek dirkeu 

        $sekDirkeuRole = new Role();
        $sekDirkeuRole->name = "sek_dirkeu";
        $sekDirkeuRole->display_name = "Sekretaris Direktur Keuangan dan SDM";
        $sekDirkeuRole->save();

        $user_sek_dirkeu = new User();
        $user_sek_dirkeu->name = "Sekretaris Dirkeu";
        $user_sek_dirkeu->nip = "sekt_dirkeu";
        $user_sek_dirkeu->email = "sekt_dirkeu@inka.co.id";
        $user_sek_dirkeu->password = bcrypt('rahasia');
        $user_sek_dirkeu->jabatan_id = 1;
        $user_sek_dirkeu->divisi_id = 1;
        $user_sek_dirkeu->save();        
        $user_sek_dirkeu->attachRole($sekDirkeuRole);

        $sekdir = new mSekdir();
        $sekdir->user_id = $user_sek_dirkeu->id;
        $sekdir->direksi_id = 3; // lihat master direksi 
        $sekdir->is_active = 1;
        $sekdir->save();

        // sek dirkomtek 

        $sekDirkomtekRole = new Role();
        $sekDirkomtekRole->name = "sek_dirkomtek";
        $sekDirkomtekRole->display_name = "Sekretaris Direktur Komersial dan Teknologi";
        $sekDirkomtekRole->save();

        $user_sek_dirkomtek = new User();
        $user_sek_dirkomtek->name = "Sekretaris Dirkomtek";
        $user_sek_dirkomtek->nip = "sekt_dirkomtek";
        $user_sek_dirkomtek->email = "sekt_dirkomtek@inka.co.id";
        $user_sek_dirkomtek->password = bcrypt('rahasia');
        $user_sek_dirkomtek->jabatan_id = 1;
        $user_sek_dirkomtek->divisi_id = 1;
        $user_sek_dirkomtek->save();        
        $user_sek_dirkomtek->attachRole($sekDirkomtekRole);

        $sekdir = new mSekdir();
        $sekdir->user_id = $user_sek_dirkomtek->id;
        $sekdir->direksi_id = 2; // lihat master direksi 
        $sekdir->is_active = 1;
        $sekdir->save();

        // sek dirprod 

        $sekDirprodRole = new Role();
        $sekDirprodRole->name = "sek_dirprod";
        $sekDirprodRole->display_name = "Sekretaris Direktur Produksi";
        $sekDirprodRole->save();

        $user_sek_dirprod = new User();
        $user_sek_dirprod->name = "Sekretaris Dirprod";
        $user_sek_dirprod->nip = "sekt_dirprod";
        $user_sek_dirprod->email = "sekt_dirprod@inka.co.id";
        $user_sek_dirprod->password = bcrypt('rahasia');
        $user_sek_dirprod->jabatan_id = 1;
        $user_sek_dirprod->divisi_id = 1;
        $user_sek_dirprod->save();        
        $user_sek_dirprod->attachRole($sekDirprodRole);

        $sekdir = new mSekdir();
        $sekdir->user_id = $user_sek_dirprod->id;
        $sekdir->direksi_id = 4; // lihat master direksi 
        $sekdir->is_active = 1;
        $sekdir->save();

    }
}

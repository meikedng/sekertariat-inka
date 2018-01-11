<?php

use Illuminate\Database\Seeder;
use App\mDireksi;
use App\mDirektorat;

class DirektoratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_direktorat = ['Direktorat Utama','Direktorat Komersial dan Teknologi',
                'Direktorat Keuangan dan SDM','Direktorat Produksi'];
        $dir_code = ['DIRUT','DIRKOMTEK','DIRKEU','DIRPROD'];

        $list_direksi = ['R. Agus H Purnomo','Hendy Hendratno Adji','Muhammad Nur Sodiq',
                'Yunendar Aryo Handoko'];
        
        $jabatan_direksi = ['Direktur Utama','Direktur Komersial dan Teknologi','Direktur Keuangan dan SDM',
                'Direktur Produksi'];

        for ($i = 0; $i < count($list_direktorat);$i++){
            $direktorat = new mDirektorat;
            
            $direktorat->nama_direktorat = $list_direktorat[$i];
            $direktorat->dir_code = $dir_code[$i];
            $direktorat->save();

            $direksi = new mDireksi();
              
            $direksi->nama_direksi = $list_direksi[$i];
            $direksi->jabatan_direksi = $jabatan_direksi[$i];
            $direksi->id_direktorat = $direktorat->id;
            $direksi->save();
        }
    }
}

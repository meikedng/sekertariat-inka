<?php

use Illuminate\Database\Seeder;
use App\mStatusTujuanDokumen;

class StatusTujuanDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_status = ['Belum Diserahkan','Telah Diserahkan','Belum Selesai','Selesai'];

        foreach ($list_status as $status){
            $status_doc = new mStatusTujuanDokumen();
            $status_doc->description = $status;
            $status_doc->save();
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\mStatusDokumen;

class StatusDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_status = ['Start','On Process','Done'];

        foreach ($list_status as $status){
            $status_doc = new mStatusDokumen();
            $status_doc->description = $status;
            $status_doc->save();
        }
        
    }
}

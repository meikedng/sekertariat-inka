<?php

use Illuminate\Database\Seeder;
use App\mDivisi;

class AnakPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_anak_perusahaan = ['PT INKA Multi Solusi','PT INKA Multi Solusi Consulting'
                    ,'PT INKA Multi Solusi Trading','PT INKA Multi Solusi Service','PT Rekaindo Global Jasa'];

        foreach($list_anak_perusahaan as $comp){
            $new_comp = new mDivisi();
            $new_comp->division_name = $comp;
            $new_comp->parent = 1;
            $new_comp->direktorat_id = 1;
            $new_comp->save();
        }
    }
}

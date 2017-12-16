<?php

use Illuminate\Database\Seeder;
use App\mTipeDokumen;

class TipeDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_tipe = ['Surat Masuk Internal','Surat Masuk Eksternal',
                        'Memo Internal'];
        $code = ['SMI','SME','MI'];

        for ($i =0 ; $i<count($list_tipe);$i++){
            $tipe_doc = new mTipeDokumen();
            $tipe_doc->description = $list_tipe[$i];
            $tipe_doc->code = $code[$i];
            $tipe_doc->save();
        }
    }
}

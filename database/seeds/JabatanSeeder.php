<?php

use Illuminate\Database\Seeder;
use App\mJabatan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::selectSheetsByIndex(0)->load('/public/seeder_file/seeder_jabatan.xlsx', function($reader){
            //options
        })->get();
        //dd($rows);

        $rowRules = [
            'id' => 'required',
            'name' => 'required',
        ];

        $i= 0;
        foreach($rows as $row)
        {
            $validator = Validator::make($row->toArray(), $rowRules);
            if($validator->fails())
            {
                continue;
            }

            try{
                $jabatan = mJabatan::create([
                    'id' => $row['id'],
                    'jabatan_name' => $row['name'],
                ]);
                
            } 
            catch(Exception $e){
                continue;
            }
            $i++;   
        }
    }
}

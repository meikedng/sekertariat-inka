<?php

use Illuminate\Database\Seeder;
use App\mDivisi;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::selectSheetsByIndex(0)->load('/public/seeder_file/seeder_unit.xlsx', function($reader){
            //options
        })->get();
        //dd($rows);

        $rowRules = [
            'id' => 'required',
            'nama' => 'required',
            'parent' => 'required',
        ];

        $i= 0;
        foreach($rows as $row)
        {
            
            $validator = Validator::make($row->toArray(), $rowRules);
            
            if($validator->fails())
            {
               // dd($validator);
                continue;
            }

            try{
                $unit = mDivisi::create([
                    'id' => $row['id'],
                    'division_name' => $row['nama'], 
                    'parent' => $row['parent'],
                    'direktorat_id' => $row['direktorat'],
                ]);
            } 

            catch(Exception $e){
                continue;
            }
            $i++;   
        }
    }
}

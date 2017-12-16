<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::selectSheetsByIndex(0)->load('/public/seeder_file/seeder_user.xlsx', function($reader){
            //options
        })->get();
       
        $rowRules = [
            'nip' => 'required',
            'nama' => 'required',
            'unit' => 'required',
            'jabatan' => 'required',
            
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
                $user = new User();
                $user->name = $row['nama'];
                $user->nip = $row['nip'];
                $user->divisi_id = $row['unit'];
                $user->jabatan_id = $row['jabatan'];
                $user->password = bcrypt($row['nip']);
                $user->save();
            } 

            catch(Exception $e){
                
                continue;
            }
            $i++;   
        }

    }
}


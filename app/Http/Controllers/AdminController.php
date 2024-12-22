<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function loadDatabase(){
        return DB::select('show databases;');
    }

    public function loadTable(Request $request){
        $database  = $request->database;

        DB::select('use '.$database.';');
        $data =  DB::select('show tables');
      
        $result= [];
        $i = 0;
        
        foreach ($data as $key => $value) {
            
             $result[$i] = array('table'=>($value->{'Tables_in_'.$database}));
            
             $i = $i+1;
        }
        return json_encode($result);
    }
}

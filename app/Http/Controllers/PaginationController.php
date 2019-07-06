<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Passenger;
use DB;
class PaginationController extends Controller
{
    public function index(){
        return view('passenger2');
    }

    public function getFullData(){
       
      return Passenger::paginate(3);
    }

    public function getSearchData($name,$email,$id,$all_search){
        $columns = DB::getSchemaBuilder()->getColumnListing('passengers');
        //dd($columns);
        $passengers = Passenger::select('*');
        if($all_search != 'none'){
            foreach($columns as $column){
                $passengers->OrWhere($column, 'like', '%' . $all_search. '%');
            }
        }
       
        if($name != 'none'){
            $passengers->where('name', 'like', '%' . $name. '%');
        } 
        if($email != 'none'){
            $passengers->where('email', 'like', '%' . $email. '%');
        } 
        if($id != 'none'){
            $passengers->where('id',$id);
        }
        
        return $passengers->paginate(5);
    }
}

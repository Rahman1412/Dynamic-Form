<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function home(){
        return view("pages.home");
    }
    // $validate->errors() Return error in associative array format
    // $validate->errors()->all() Return error as an index array format
    public function addItems(Request $request){
        $rules = array(
            'title.*'  => 'required',
            'price.*'  => 'required',
            'file.*' => 'required|image|mimes:jpeg,png,jpg'
        );
        $validate = Validator::make($request->all(), $rules);

        if($validate->fails()){
            return response()->json([
                'code'   => 'validation_error',
                'error'  => $validate->errors()
            ],400);
        }

        DB::beginTransaction();
        try{
            throw new \Exception("New Error");
        }catch(Exception $e){
            return response([
                "status" => false,
                "message" -> $e->getMessage()
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}

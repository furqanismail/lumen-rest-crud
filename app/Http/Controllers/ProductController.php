<?php

namespace App\Http\Controllers;

use App\Models\Products;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getData(){
        $data = Products::all();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function store(Request $request){

        $this->validate($request, [
            'code' =>'required',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);


        $data = new Products;

        $data->code = $request->code;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->status = $request->status;

        $data->save();

        return response()->json([
            "status" => "success",
            "message" => "data berhasil ditambahkan"
        ]);
    }

    public function update(Request $request, $id){
        $data = Products::find($id);
        if(is_null($data)){
            return Response::json('not found', 404);
        }
        $data->code = $request->code;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->status = $request->status;

        $data->save();

        return response()->json([
            "status" => "success",
            "message" => "data berhasil diupdate"
        ]);
    }

    public function destroy($id){
        $data = Products::find($id);
        if(is_null($data)){
            return Response::json("not found", 404);
        }
        $success =  $data->delete();
        if(!$success){
            return Response::json('error deleting', 500);
        }
        return response()->json([
            "status" => "success",
            "message" => "data berhasil dihapus"
        ]);
    }
}

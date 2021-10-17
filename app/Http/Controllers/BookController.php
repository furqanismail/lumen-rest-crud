<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
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

    public function index ()
    {
        $book = Book::all();
        return response()->json([
           'status' => 'success',
           'data' => $book
        ]);
    }

    public function store (Request $request)
    {
        $rules = [
          'title' => 'required|string',
          'author' => 'required|string',
          'years' => 'required|string',
          'price' => 'required|string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            return response()->json([
               'status' => 'error',
               'message' => $validator->errors()
            ]);
        }

        $book = Book::create($data);
        return response()->json([
           'status' => 'success',
           'message' => 'data add successfully'
        ]);
    }

    public function update ($id, Request $request)
    {
        $rules = [
            'title' => 'string',
            'author' => 'string',
            'years' => 'string',
            'price' => 'string'
        ];

        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $book = Book::find($id);
        if (!$book){
            return response()->json([
               'status' => 'error',
               'message' => 'data not found'
            ]);
        }

        $book->fill($data);
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'data update successfully'
        ]);
    }

    public function destroy ($id)
    {
        $book = Book::find($id);
        if (!$book){
            return response()->json([
               'status' => 'error',
               'message' => 'data not found'
            ]);
        }

        $book->delete();
        return response()->json([
           'status' => 'success',
           'message' => 'data deleted successfully'
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BookController extends Controller
{
    public function index()
    {
        $books = Books::get();
        return response()->json($books);
    }

    public function store(Request $request)
    {
    	$validator = $request->validate([
		            'name' => 'required',
		            'author' => 'required',
		            'publish_date' => 'required',
		        ]);
    	if ($validator->fails()) {
            return response()->json($validator->errors());       
        }
		Books::create($validator);
    	return response()->json([
            "message" => "Book Added."
        ], 200);
    }

    public function show($id)
    {
    	$book = Books::find($id);
    	if (!empty($book)) {
    		return response()->json($book);
    	} else {
    		return response()->json([
                "message" => "Book not found"
            ], 404);
    	}
    }

    public function update(Request $request)
    {
    	if (Books::where('id', $request->id)->exists()) {
            $book = Books::find($request->id);
            $book->name = is_null($request->name) ? $book->name : $request->name;
            $book->author = is_null($request->author) ? $book->author : $request->author;
            $book->publish_date = is_null($request->publish_date) ? $book->publish_date : $request->publish_date;
            $book->save();
            return response()->json([
                "message" => "Book Updated."
            ], 200);
        }else{
            return response()->json([
                "message" => "Book Not Found."
            ], 404);
        }
    }

    public function destroy($id)
    {
        if(Books::where('id', $id)->exists()) {
            $book = Books::find($id);
            $book->delete();

            return response()->json([
              "message" => "records deleted."
            ], 200);
        } else {
            return response()->json([
              "message" => "book not found."
            ], 404);
        }
    }
}

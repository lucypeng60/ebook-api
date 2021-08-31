<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            book::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'publisher' => 'required',
                'date_of_issue' => 'required | date'
            ]
        );

        if ($validator -> fails()){
            return response()->json(
                $validator->errors(),
                400
            );
        }

        book::create($input);

        return response()->json(
            [
                'Book created successfully'
            ],
            201
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(
            book::findOrFail($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'publisher' => 'required',
                'date_of_issue' => 'required | date'
            ]
        );

        if ($validator -> fails()){
            return response()->json(
                [
                    $validator->errors()
                ],
                400
            );
        }

        $book = book::findOrFail($id);
        $book->title = $input['title'];
        $book->description = $input['description'];
        $book->author = $input['author'];
        $book->publisher = $input['publisher'];
        $book->date_of_issue = $input['date_of_issue'];
        $book->save();

        return response()->json(
            'Book edited successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book::destroy($id);
        return response()->json(
            'Book deleted successfully',
            200
        );
    }
}
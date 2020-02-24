<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $authors = \App\Author::all();
      return view('authors.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
      ]);
      $author = new \App\Author($data);
      $author->save();

      return redirect(route('authors.show', $author->id))->with('success', 'Author was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $author = \App\Author::find($id);
      return view('authors.show', ['author' => $author]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $author = \App\Author::find($id);
      return view('authors.edit', ['author' => $author]);
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
      $data = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
      ]);
      $author = \App\Author::find($id);
      $author->fill($data);
      $author->save();

      return redirect(route('authors.show', $author->id))->with('success', 'Author was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $author = \App\Author::find($id);
      $author->delete();

      return redirect(route('authors.index'))->with('success', 'Author was successfully deleted.');
    }
}

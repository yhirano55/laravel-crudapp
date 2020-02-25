<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $title = $request->input('title');
      $query = \App\Book::query();

      if (!empty($title)) {
        $query->where('title', 'like', '%'.$title.'%');
      }

      $books = $query->paginate(5);
      return view('books.index')
        ->with('books', $books)
        ->with('title', $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $authors = \App\Author::all();
      return view('books.create')->with('authors', $authors);
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
        'title' => 'required',
        'summary' => 'required',
        'price' => 'required',
        'author_id' => 'required',
      ]);
      $book = new \App\Book($data);
      $book->save();

      return redirect(route('books.show', $book->id))->with('success', 'Book was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $book = \App\Book::find($id);
      return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $book = \App\Book::find($id);
      $authors = \App\Author::all();
      return view('books.edit')->with('book', $book)->with('authors', $authors);
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
        'title' => 'required',
        'summary' => 'required',
        'price' => 'required',
        'author_id' => 'required',
      ]);
      $book = \App\Book::find($id);
      $book->fill($data);
      $book->save();

      return redirect(route('books.show', $book->id))->with('success', 'Book was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $book = \App\Book::find($id);
      $book->delete();

      return redirect(route('books.index'))->with('success', 'Book was successfully deleted.');
    }
}

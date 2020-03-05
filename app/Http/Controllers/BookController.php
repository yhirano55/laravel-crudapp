<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
      $title = $request->input('title');
      $author_id = $request->input('author_id');
      $author_first_name = $request->input('author_first_name');
      $author_last_name = $request->input('author_last_name');
      $query = \App\Book::query();
      $query->leftJoin('authors', 'books.author_id', '=', 'authors.id');

      if (!empty($title)) {
        $query->where('books.title', 'like', '%'.$title.'%');
      }

      if (!empty($author_id)) {
        $query->where('books.author_id', '=', $author_id);
      }

      if (!empty($author_first_name)) {
        $query->where('authors.first_name', 'like', '%'.$author_first_name.'%');
      }

      if (!empty($author_last_name)) {
        $query->where('authors.last_name', 'like', '%'.$author_last_name.'%');
      }

      $books = $query->paginate(5);
      return view('books.index')
        ->with('books', $books)
        ->with('title', $title)
        ->with('author_id', $author_id)
        ->with('author_first_name', $author_first_name)
        ->with('author_last_name', $author_last_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'title' => 'required|max:255',
        'summary' => 'required|max:2000',
        'price' => 'required|numeric',
        'author_id' => 'required|exists:App\Author,id',
      ]);
      $book = new \App\Book($data);
      $book->save();

      return redirect(route('books.show', $book->id))->with('success', 'Book was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
      $book = \App\Book::findOrFail($id);
      return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
      $book = \App\Book::findOrFail($id);
      $authors = \App\Author::all();
      return view('books.edit')->with('book', $book)->with('authors', $authors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $data = $request->validate([
        'title' => 'required|max:255',
        'summary' => 'required|max:2000',
        'price' => 'required|numeric',
        'author_id' => 'required|exists:App\Author,id',
      ]);
      $book = \App\Book::findOrFail($id);
      $book->fill($data);
      $book->save();

      return redirect(route('books.show', $book->id))->with('success', 'Book was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
      $book = \App\Book::findOrFail($id);
      $book->delete();

      return redirect(route('books.index'))->with('success', 'Book was successfully deleted.');
    }

    /**
     * Export a listing of the resource with csv format.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
      return Excel::download(new BookExport, 'books.csv');
    }
}

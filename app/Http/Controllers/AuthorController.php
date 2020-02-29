<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AuthorExport;
use App\Http\Requests\StoreAuthorPost;
use Maatwebsite\Excel\Facades\Excel;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $first_name = $request->input('first_name');
      $last_name = $request->input('last_name');
      $book_title = $request->input('book_title');
      $query = \App\Author::query();

      if (!empty($first_name)) {
        $query->where('first_name', 'like', '%'.$first_name.'%');
      }

      if (!empty($last_name)) {
        $query->where('last_name', 'like', '%'.$last_name.'%');
      }

      if (!empty($book_title)) {
        $query
          ->join('books', 'authors.id', '=', 'books.author_id')
          ->where('books.title', 'like', '%'.$book_title.'%');
      }

      $authors = $query->paginate(5);
      return view('authors.index')
        ->with('authors', $authors)
        ->with('first_name', $first_name)
        ->with('last_name', $last_name)
        ->with('book_title', $book_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAuthorPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorPost $request)
    {
      $validated = $request->validated();
      $author = new \App\Author();
      $author->first_name = $request->get('first_name');
      $author->last_name = $request->get('last_name');
      $author->setImage($request->file('image'));
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
     * @param  \App\Http\Requests\StoreAuthorPost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAuthorPost $request, $id)
    {
      $validated = $request->validated();
      $author = \App\Author::find($id);
      $author->first_name = $request->get('first_name');
      $author->last_name = $request->get('last_name');
      $author->deleteImage($request->get('image_delete_flag'));
      $author->setImage($request->file('image'));
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

    /**
     * Export a listing of the resource with csv format.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
      return Excel::download(new AuthorExport, 'authors.csv');
    }
}

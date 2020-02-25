@extends('layouts.app')
@section('title', 'Books List')
@section('content')
<div class="container">
  <h1 class="h3">Books List</h1>

  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('books.index') }}" method="get">
        <div class="form-row">
          <div class="col-auto">
            <input type="text" name="title" value="{{ $title }}" class="form-control" placeholder="title" />
          </div>
          <div class="col-auto">
            <input type="text" name="author_id" value="{{ $author_id }}" class="form-control" placeholder="author id" />
          </div>
          <div class="col-auto">
            <input type="text" name="author_first_name" value="{{ $author_first_name }}" class="form-control" placeholder="author first name" />
          </div>
          <div class="col-auto">
            <input type="text" name="author_last_name" value="{{ $author_last_name }}" class="form-control" placeholder="author last name" />
          </div>
          <div class="col-auto">
            <input type="submit" value="search" class="btn btn-primary" />
          </div>
        </div>
      </form>
    </div>
  </div>

  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">id</th>
        <th scope="col">title</th>
        <th scope="col">price</th>
        <th scope="col">author</th>
        <th scope="col">created at</th>
        <th scope="col">updated at</th>
        <th colspan="3"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($books as $book)
        <tr>
          <th scope="row">{{ $book->id }}</th>
          <td>{{ $book->title }}</td>
          <td>{{ $book->price }}</td>
          <td>{{ $book->author->fullName() }}</td>
          <td>{{ $book->created_at }}</td>
          <td>{{ $book->updated_at }}</td>
          <td><a href="{{ route('books.show', $book->id)}}" class="btn btn-secondary btn-block btn-sm">Show</a></td>
          <td><a href="{{ route('books.edit', $book->id)}}" class="btn btn-secondary btn-block btn-sm">Edit</a></td>
          <td>
            <form action="{{ route('books.destroy', $book->id) }}" method="post">
              @csrf
              @method('DELETE')
              <input type="submit" value="Delete" class="btn btn-danger btn-block btn-sm" />
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $books->links() }}

  <hr>

  <p><a href="{{ route('books.create') }}" class="btn btn-primary">Create new book</a></p>
</div>
@endsection

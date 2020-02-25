@extends('layouts.app')
@section('title', 'Authors List')
@section('content')
<div class="container">
  <h1 class="h3">Authors List</h1>

  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('authors.index') }}" method="get">
        <div class="form-row">
          <div class="col-auto">
            <input type="text" name="first_name" value="{{ $first_name }}" class="form-control" placeholder="first name" />
          </div>
          <div class="col-auto">
            <input type="text" name="last_name" value="{{ $last_name }}" class="form-control" placeholder="last name" />
          </div>
          <div class="col-auto">
            <input type="text" name="book_title" value="{{ $book_title }}" class="form-control" placeholder="book title" />
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
        <th scope="col">first name</th>
        <th scope="col">last name</th>
        <th scope="col">full name</th>
        <th scope="col">created at</th>
        <th scope="col">updated at</th>
        <th colspan="4"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($authors as $author)
        <tr>
          <th scope="row">{{ $author->id }}</th>
          <td>{{ $author->first_name }}</td>
          <td>{{ $author->last_name }}</td>
          <td>{{ $author->fullName() }}</td>
          <td>{{ $author->created_at }}</td>
          <td>{{ $author->updated_at }}</td>
          <td><a href="{{ route('authors.show', $author->id)}}" class="btn btn-secondary btn-block btn-sm">Show</a></td>
          <td><a href="{{ route('books.index', ['author_id' => $author->id])}}" class="btn btn-secondary btn-block btn-sm">Books</a></td>
          <td><a href="{{ route('authors.edit', $author->id)}}" class="btn btn-secondary btn-block btn-sm">Edit</a></td>
          <td>
            <form action="{{ route('authors.destroy', $author->id) }}" method="post">
              @csrf
              @method('DELETE')
              <input type="submit" value="Delete" class="btn btn-danger btn-block btn-sm" />
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $authors->links() }}

  <hr>

  <p><a href="{{ route('authors.create') }}" class="btn btn-primary">Create new author</a></p>
</div>
@endsection

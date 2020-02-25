@extends('layouts.app')
@section('title', 'Book')
@section('content')
<div class="container">
  <h1 class="h3">Book (id: {{ $book->id }})</h1>

  <table class="table">
    <tr>
      <th>id</th>
      <td>{{ $book->id }}</td>
    </tr>
    <tr>
      <th>title</th>
      <td>{{ $book->title }}</td>
    </tr>
    <tr>
      <th>summary</th>
      <td>{{ $book->summary }}</td>
    </tr>
    <tr>
      <th>price</th>
      <td>{{ $book->price }}</td>
    </tr>
    <tr>
      <th>author</th>
      <td>{{ $book->author->fullName() }}</td>
    </tr>
    <tr>
      <th>created at</th>
      <td>{{ $book->created_at }}</td>
    </tr>
    <tr>
      <th>updated at</th>
      <td>{{ $book->updated_at }}</td>
    </tr>
  </table>

  <hr>

  <a href="{{ route('books.index')}}" class="btn btn-secondary">Back</a>
</div>
@endsection

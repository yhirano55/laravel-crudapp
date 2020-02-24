@extends('layouts.app')
@section('title', 'Authors List')
@section('content')
<div class="container">
  <h1 class="h3">Authors List</h1>

  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">id</th>
        <th scope="col">first name</th>
        <th scope="col">last name</th>
        <th scope="col">full name</th>
        <th scope="col">created at</th>
        <th scope="col">updated at</th>
        <th colspan="3"></th>
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

  <hr>

  <p><a href="{{ route('authors.create') }}" class="btn btn-primary">Create new author</a></p>
</div>
@endsection

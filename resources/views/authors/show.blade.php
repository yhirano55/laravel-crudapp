@extends('layouts.app')
@section('title', 'Author')
@section('content')
<div class="container">
  <h1 class="h3">Author (id: {{ $author->id }})</h1>

  <table class="table">
    <tr>
      <th>id</th>
      <td>{{ $author->id }}</td>
    </tr>
    <tr>
      <th>first name</th>
      <td>{{ $author->first_name }}</td>
    </tr>
    <tr>
      <th>last name</th>
      <td>{{ $author->last_name }}</td>
    </tr>
    <tr>
      <th>full name</th>
      <td>{{ $author->fullName() }}</td>
    </tr>
    <tr>
      <th>image</th>
      <td>
        @if (!empty($author->image_path))
          <img src="{{ asset('storage/'.$author->image_path) }}" />
        @else
          Image Not Found
        @endif
      </td>
    </tr>
    <tr>
      <th>created at</th>
      <td>{{ $author->created_at }}</td>
    </tr>
    <tr>
      <th>updated at</th>
      <td>{{ $author->updated_at }}</td>
    </tr>
  </table>

  <hr>

  <a href="{{ route('authors.index')}}" class="btn btn-secondary">Back</a>
</div>
@endsection

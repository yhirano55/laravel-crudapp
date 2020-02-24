@extends('layouts.app')
@section('title', 'Edit Author')
@section('content')
<div class="container">
  <h1 class="h3">Edit Author</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul style="margin: 0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('authors.update', $author->id) }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="first_name">first name</label>
      <input type="text" name="first_name" value="{{ $author->first_name }}" class="form-control" />
    </div>

    <div class="form-group">
      <label for="last_name">last name</label>
      <input type="text" name="last_name" value="{{ $author->last_name }}" class="form-control" />
    </div>

    <input type="submit" value="Update Author" class="btn btn-primary" />
  </form>

  <hr>

  <p><a href="{{ route('authors.show', $author->id)}}" class="btn btn-secondary">Back</a></p>
</div>
@endsection
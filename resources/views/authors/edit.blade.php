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

  <form method="post" action="{{ route('authors.update', $author->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="first_name">first name</label>
      <input type="text" name="first_name" value="{{ old('first_name', $author->first_name) }}" class="form-control" />
    </div>

    <div class="form-group">
      <label for="last_name">last name</label>
      <input type="text" name="last_name" value="{{ old('last_name', $author->last_name) }}" class="form-control" />
    </div>

    <div class="form-group">
      <label for="image">image</label>
      <input type="file" name="image" class="form-control" />
    </div>

    @if (!empty($author->image_path))
      <div class="form-group form-check">
        <p><img src="{{ asset('storage/'.$author->image_path) }}" width="200" height="200" alt="" /></p>
        <input type="checkbox" name="image_delete_flag" id="image_delete_flag" value="1" />
        <label for="image_delete_flag">Delete image</label>
      </div>
    @endif

    <input type="submit" value="Update Author" class="btn btn-primary" />
  </form>

  <hr>

  <p><a href="{{ route('authors.show', $author->id)}}" class="btn btn-secondary">Back</a></p>
</div>
@endsection

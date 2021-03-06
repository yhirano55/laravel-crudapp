@extends('layouts.app')
@section('title', 'Edit Book')
@section('content')
<div class="container">
  <h1 class="h3">Edit Book</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul style="margin: 0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('books.update', $book->id) }}">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="title">title</label>
      <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" />
    </div>

    <div class="form-group">
      <label for="summary">summary</label>
      <textarea name="summary" class="form-control">{{ old('summary', $book->summary) }}</textarea>
    </div>

    <div class="form-group">
      <label for="price">price</label>
      <input type="number" name="price" class="form-control" value="{{ old('price', $book->price) }}" />
    </div>

    <div class="form-group">
      <label for="author_id">author_id</label>
      <select name="author_id" class="form-control">
        <option value="">選択してください</option>
        @foreach ($authors as $author)
          <option value="{{ $author->id }}" {{ $author->id == old('author_id', $book->author->id) ? 'selected' : null }}>{{ $author->fullName() }}</option>
        @endforeach
      </select>
    </div>

    <input type="submit" value="Update Book" class="btn btn-primary" />
  </form>

  <hr>

  <p><a href="{{ route('books.show', $book->id)}}" class="btn btn-secondary">Back</a></p>
</div>
@endsection

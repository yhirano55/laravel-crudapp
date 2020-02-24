@extends('layouts.app')
@section('title', 'Create Author')
@section('content')
<div class="container">
  <h1 class="h3">Create Author</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul style="margin: 0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('authors.store') }}">
    @csrf

    <div class="form-group">
      <label for="first_name">first name</label>
      <input type="text" name="first_name" class="form-control" />
    </div>

    <div class="form-group">
      <label for="last_name">last name</label>
      <input type="text" name="last_name" class="form-control" />
    </div>

    <input type="submit" value="Create Author" class="btn btn-primary" />
  </form>

  <hr>

  <p><a href="{{ route('authors.index')}}" class="btn btn-secondary">Back</a></p>
</div>
@endsection

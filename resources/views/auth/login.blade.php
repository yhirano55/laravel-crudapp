@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container">
  <h1 class="h3">ログインフォーム</h1>

  @isset($message)
    <div class="alert alert-danger">
      <ul style="margin: 0">
        <li>{{ $message }}</li>
      </ul>
    </div>
  @endisset

  <form name="loginform" action="/auth/login" method="post">
    @csrf

    <div class="form-group">
      <label for="email">メールアドレス</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
    </div>

    <div class="form-group">
      <label for="password">パスワード</label>
      <input type="password" name="password" class="form-control" />
    </div>

    <input type="submit" value="ログイン" class="btn btn-primary" />
  </form>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container">
  <h1 class="h3">ユーザー登録フォーム</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul style="margin: 0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form name="registerform" action="/auth/register" method="post">
    @csrf

    <div class="form-group">
      <label for="name">名前</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
    </div>

    <div class="form-group">
      <label for="email">メールアドレス</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
    </div>

    <div class="form-group">
      <label for="password">パスワード</label>
      <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
      <label for="password_confirmation">パスワード（確認）</label>
      <input type="password" name="password_confirmation" class="form-control" />
    </div>

    <input type="submit" value="送信" class="btn btn-primary" />
  </form>
</div>
@endsection

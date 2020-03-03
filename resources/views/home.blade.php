@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="container">
  <h1 class="h3">Welcome</h1>
  @if (Auth::check())
    <p>こんにちは！ {{ \Auth::user()->name }} さん</p>
    <p><a href="/auth/logout" class="btn btn-primary btn-block">ログアウト</a></p>
  @else
    <p>こんにちは！ ゲストさん</p>
    <p><a href="/auth/register" class="btn btn-primary btn-block">会員登録</a></p>
    <p><a href="/auth/login" class="btn btn-primary btn-block">ログイン</a></p>
  @endif
</div>
@endsection

@extends('layouts.auth-master')
@section('content')
<h1>Login</h1>
<br>
<form method="post" id="handleAjax" action="{{url('do-login')}}" name="postform">
    @include('layouts.partials.messages')
  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" value="{{old('email')}}"  class="form-control" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    @csrf
  </div><br>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password"   class="form-control" />
  </div>
  <br>
  <div class="form-group">
    <button type="submit" class="btn btn-primary">LOGIN</button>
  </div>
</form>
@endsection

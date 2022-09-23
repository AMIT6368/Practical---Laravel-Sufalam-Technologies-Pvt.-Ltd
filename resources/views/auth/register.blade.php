@extends('layouts.auth-master')

@section('content')
<h1>Register</h1>
    <form method="post" id="handleAjax" action="{{url('do-register')}}" name="postform">
         @include('layouts.partials.messages')<br>
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" />
              </div><br>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{old('email')}}" class="form-control" />
                @csrf
              </div><br>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" />
              </div><br>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" />
              </div><br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">REGISTER</button>
              </div>
            </form>
@endsection

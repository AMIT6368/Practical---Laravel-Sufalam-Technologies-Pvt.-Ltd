@extends('layouts.auth-master')

@section('content')
    <div class="readersack">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3">
               <!-- Show any success message -->
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
          <!-- Show any success message -->

            <!-- Check user is logged in -->
            @if(\Auth::check())
              <div class='dash'>
                <h2>Dashboard   <a class="btn btn-danger me-6" href="{{url('logout')}}"> Logout</a></h2>
                <h3 class="btn btn-success me-2">You are logged in as </h3>
                 
                <br> 
                <div class="btn btn-outline-success me-6">
                 <strong>Full Name: </strong> {{\Auth::user()->name}}  <br>
                 <strong>Email: </strong> {{\Auth::user()->email}}  <br>
                 <strong>Created Date: </strong> {{\Auth::user()->created_at}} 
                <br>
               </div>

                </div> 
            @else
            <div class='dash '>
              <div class='error'> You are not logged in  </div>
              <div>  <a href="{{url('login')}}">Login</a> | <a href="{{url('register')}}">Register</a> </div>
            </div>
             
            @endif
           <!-- Check user is logged in --> 
          </div>
        </div>
      </div>
    </div>
@endsection

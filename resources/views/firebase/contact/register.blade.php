@extends('firebase.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">

      @if(session('status'))
      <h4 class="alert alert-warning mb-2">{{session('status')}}</h4>
      @endif

      <div class="card">
        <div class="card-header">
          <h4>Register
            <a href="{{ url('/') }}" class="btn btn-sm btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">

          <form action="{{url('register')}}" method="POST">
            @csrf

            <div class="form-group mb-3">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Email Address</label>
              <input type="text" name="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection
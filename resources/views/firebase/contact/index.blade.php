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
          <h4>Contact List
            <a href="{{ url('add-contact') }}" class="btn btn-sm btn-primary float-end">Add Contact</a>
          </h4>
        </div>
        <div class="card-body">
          contact data
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
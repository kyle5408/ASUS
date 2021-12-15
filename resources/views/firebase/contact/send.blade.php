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
          <h4>Send Message
            <a href="{{ url('contacts') }}" class="btn btn-sm btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">

          <form action="{{url('send')}}" method="POST">
            @csrf

            <div class="form-group mb-3">
              <label>Topic:</label>
              <input type="text" name="topic" class="form-control" required>

              <div class="form-group mb-3">
                <label>Message:</label>
                <textarea type="text" name="msg" class="form-control" required></textarea>

                <div class="form-group mt-3 mb-3 float-end">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
  const firebaseConfig = {
    apiKey: "AIzaSyAzpf5h0KMks9t-16uYOtXIlhLTSjyusXs",
    authDomain: "asus-a7619.firebaseapp.com",
    databaseURL: "https://asus-a7619-default-rtdb.firebaseio.com",
    projectId: "asus-a7619",
    storageBucket: "asus-a7619.appspot.com",
    messagingSenderId: "795078141886",
    appId: "1:795078141886:web:d9d7d36ac83e91b6ccfbef",
    measurementId: "G-WJQ21PL3CT"
  };
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
      body: payload.notification.body,
      icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
  });
</script>

@endsection
@extends('firebase.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">

      @if(session('status'))
      <h4 class="alert alert-warning mb-2">{{session('status')}}</h4>
      @endif

      <div class="alert alert-warning mb-2" id="error_msg" hidden>
      </div>

      <div class="card">
        <div class="card-header">
          <h4>Register
            <a href="{{ url('/') }}" class="btn btn-sm btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">

          <form action="{{url('register')}}" method="POST" name="register">
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
              <input type="text" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Device Token</label>
              <input type="text" name="device_token" id="device_token" class=" form-control" disabled>
              <h6 style="font-style:italic">If device token is empty, please use Microsoft Edge to get device token.</h6>
            </div>



            <div class="form-group mb-3">
              <button class="btn btn-primary" id="register">Register</button>
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
  const registerBtn = document.querySelector('#register');
  const email = document.querySelector('#email');
  const password = document.querySelector('#password');
  const errMsg = document.querySelector('#error_msg');

  function initFirebaseMessagingRegistration() {
    messaging
      .requestPermission()
      .then(function() {
        return messaging.getToken()
      })
      .then(function(token) {
        console.log('Token', token);

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        document.querySelector('#device_token').value = token
        document.querySelector('#device_token').disabled = true
      }).catch(function(err) {
        console.log('User Chat Token Error' + err);
        errMsg.hidden = false
        errMsg.innerHTML = err
      });
  }

  // function register() {
  //   document.register.action = "/register"
  //   document.register = "POST"
  //   document.register.submit()
  // }

  messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
      body: payload.notification.body,
      icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
  });

  registerBtn.addEventListener("click", e => {
    e.preventDefault()
    firebase.auth().createUserWithEmailAndPassword(email.value, password.value)
      .then(e => {
        document.querySelector('#device_token').disabled = false
        document.register.submit()
      })
      .catch(error => {
        console.log(error.message)
        errMsg.hidden = false
        errMsg.innerHTML = error.message
      })
  })

  window.addEventListener('load', initFirebaseMessagingRegistration())
  // window.addEventListener('submit', () => {
  //   document.querySelector('#device_token').disabled = false
  // })
</script>

@endsection
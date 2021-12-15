@extends('firebase.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6">

      @if(session('status'))
      <h4 class="alert alert-warning mb-2">{{session('status')}}</h4>
      @endif

      <div class="alert alert-warning mb-2" id="error_msg" hidden>
      </div>

      <div class="card">
        <div class="card-header">
          <h4>Login</h4>
        </div>
        <div class="card-body">

          <form action="{{ url('login')}}" method="POST" name="login">
            @csrf

            <div class="form-group mb-3">
              <label>Email Address</label>
              <input type="text" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <input type="hidden" class="login_data" id="loginData">


            <div class="form-group mb-3">
              <button class="btn btn-primary" id="login">Login</button>
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
  const email = document.querySelector('#email');
  const password = document.querySelector('#password');
  const loginData = document.querySelector('#loginData');
  const loginBtn = document.querySelector('#login');
  const errMsg = document.querySelector('#error_msg');

  loginBtn.addEventListener("click", e => {
    e.preventDefault()
    firebase.auth().signInWithEmailAndPassword(email.value, password.value)
      .then(() => {
        const user = firebase.auth().currentUser;
        firebase.auth().onAuthStateChanged(function(user) {
          if (user) {
            loginData.value = user
            console.log('logindata', loginData.value)
            document.login.submit()
          }
        })
      })
      .catch((error) => {
        console.log(error.message);
        errMsg.hidden = false
        errMsg.innerHTML = error.message
      });
  })
</script>




@endsection
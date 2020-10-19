@extends('main')

@section('title', 'Welcome | ' . config('app.name'))

@section('content')
    <section class="clearfix">
        <div class="flex-center position-ref full-height">
            <img id="home-cover" src="{{ asset('images/yourDMS.png') }}">            
        </div>
    </section>
@endsection

<script src="https://www.gstatic.com/firebasejs/6.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.6.0/firebase-firestore.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBXRU9Wn3inOEJU2AKEnn_Y1mML35JSXpg",
        authDomain: "shopiwa-main.firebaseapp.com",
        databaseURL: "https://shopiwa-main.firebaseio.com",
        projectId: "shopiwa-main",
        storageBucket: "shopiwa-main.appspot.com",
        messagingSenderId: "926622447977",
        appId: "1:926622447977:web:2776ffcdd8d75b709fa5f8"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    var db = firebase.firestore();

    db.collection("orders").add({
        customerId: 12,
        orderId: 1,
        delivery: "true"
    })
    .then(function(docRef) {
        console.log("Document written with ID: ", docRef.id);
    })
    .catch(function(error) {
        console.error("Error adding document: ", error);
    });
</script>

@section('css')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

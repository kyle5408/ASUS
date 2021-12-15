// import { initializeApp } from 'firebase/app';
// import { getFirestore, collection, getDocs } from 'firebase/firestore/lite';
// import { getDatabase } from "firebase/database";
// import { getMessaging, getToken } from "firebase/messaging";

// // Follow this pattern to import other Firebase services
// // import { } from 'firebase/<service>';

// // TODO: Replace the following with your app's Firebase project configuration
// const firebaseConfig = {
//   apiKey: "AIzaSyAzpf5h0KMks9t-16uYOtXIlhLTSjyusXs",
//   authDomain: "asus-a7619.firebaseapp.com",
//   databaseURL: "https://asus-a7619-default-rtdb.firebaseio.com",
//   projectId: "asus-a7619",
//   storageBucket: "asus-a7619.appspot.com",
//   messagingSenderId: "795078141886",
//   appId: "1:795078141886:web:d9d7d36ac83e91b6ccfbef",
//   measurementId: "G-WJQ21PL3CT"
// };

// const app = initializeApp(firebaseConfig);
// const { initializeApp } = require('firebase-admin/app');
// const database = getDatabase(app);
// const db = getFirestore(app);

// // Get a list of cities from your database
// async function getCities(db) {
//   const citiesCol = collection(db, 'cities');
//   const citySnapshot = await getDocs(citiesCol);
//   const cityList = citySnapshot.docs.map(doc => doc.data());
//   return cityList;
// }

// initializeApp({
//   credential: applicationDefault(),
//   databaseURL: firebaseConfig.databaseURL
// });

// const messaging = firebase.messaging();
// // messaging.getToken({
// //   vapidKey: "BGOJichLyieVJoZbbMNT2T-3Cryk0YwpS7Lzfn544Arvk1R-WSf_D_JQpKqIibjmBTA-Wf_xirRPmJ57YDYhzMw"});

// getToken(messaging, { vapidKey: 'BGOJichLyieVJoZbbMNT2T-3Cryk0YwpS7Lzfn544Arvk1R-WSf_D_JQpKqIibjmBTA-Wf_xirRPmJ57YDYhzMw' }).then((currentToken) => {
//   if (currentToken) {
//     // Send the token to your server and update the UI if necessary
    
//   } else {
//     // Show permission request UI
//     console.log('No registration token available. Request permission to generate one.');
//   }
// }).catch((err) => {
//   console.log('An error occurred while retrieving token. ', err);
// });


/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
  apiKey: "AIzaSyAzpf5h0KMks9t-16uYOtXIlhLTSjyusXs",
  authDomain: "asus-a7619.firebaseapp.com",
  databaseURL: "https://asus-a7619-default-rtdb.firebaseio.com",
  projectId: "asus-a7619",
  storageBucket: "asus-a7619.appspot.com",
  messagingSenderId: "795078141886",
  appId: "1:795078141886:web:d9d7d36ac83e91b6ccfbef",
  measurementId: "G-WJQ21PL3CT"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message ",
    payload,
  );
  /* Customize notification here */
  const notificationTitle = "Background Message Title";
  const notificationOptions = {
    body: "Background Message body.",
    icon: "/itwonders-web-logo.png",
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions,
  );
});
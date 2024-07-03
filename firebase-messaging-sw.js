importScripts("https://www.gstatic.com/firebasejs/9.10.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.10.0/firebase-messaging-compat.js");

firebase.initializeApp({
   apiKey: "AIzaSyAlKuyYgKlIR7S3Q40gR7bIrc1-DEG_9js",
    authDomain: "tallabatak.firebaseapp.com",
    projectId: "tallabatak",
    storageBucket: "tallabatak.appspot.com",
    messagingSenderId: "725220437952",
    appId: "1:725220437952:web:38e2c6fd7c4b474b772225",
    measurementId: "G-D7G6X1FEZW"
  });

// Necessary to receive background messages:
const messaging = firebase.messaging();

// Optional:
messaging.onBackgroundMessage((m) => {
  console.log("onBackgroundMessage", m);
});
const express = require('express');
const bodyParser = require('body-parser');
const validator = require('validator'); // Import validator library
const admin = require('firebase-admin');

// Replace with your actual Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyA-Hh8iEhaAF5N6ipMa7hfb0-nAFGwJeCY",
  authDomain: "bunainteriors-d2a39.firebaseapp.com",
  databaseURL: "https://bunainteriors-d2a39-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "bunainteriors-d2a39",
  storageBucket: "bunainteriors-d2a39.appspot.com",
  messagingSenderId: "377759841827",
  appId: "1:377759841827:web:9ccffecbcab57da9c33b96",
}

admin.initializeApp(firebaseConfig);
const db = admin.database();

const app = express();
const port = 27017; // You can change this port if needed

app.use(bodyParser.urlencoded({ extended: true }));

app.post('/submit', async (req, res) => {
  // ... Validation logic (unchanged) ...

  // Create an object for Firebase (no need for Mongoose schema)
  const appointment = {
    name,
    email,
    number,
    date,
    time,
    location,
  };

  try {
    await db.ref('appointments').push(appointment);
    res.send('Appointment booked successfully! Check your email for details.');
    // Send confirmation email as before (replace with your logic)
  } catch (err) {
    console.error('Error saving appointment:', err);
    res.status(500).send('Error booking appointment.');
  }
});

app.listen(port, () => {
  console.log(`Server listening on port ${port}`);
});

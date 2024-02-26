const mongoose = require('mongoose');

const appointmentSchema = new mongoose.Schema({
  name: String,
  email: String,
  number: Number,
  date: String,
  time: String,
  location: String,
});

module.exports = mongoose.model('Appointment', appointmentSchema);

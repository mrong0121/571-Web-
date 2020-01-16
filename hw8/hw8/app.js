var express = require("express");
var https = require("https");
var app = express();
var cors = require('cors');

app.use(cors());

app.use(express.static("./public"));





const PORT = process.env.PORT || 8080;
app.listen(PORT, () => {
  console.log(`App listening on port ${PORT}`);
  console.log('Press Ctrl+C to quit.');
});
module.exports = app;

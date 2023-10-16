<?php

// Connect to the MySQL database
$db = mysqli_connect('localhost', 'root', '', 'izreal4life');

// Check if the connection was successful
if ($db === false) {
    echo 'Error connecting to the database.';
} else {
    echo '';
}

// Get the form data from the $_POST variable
$email = $_POST['email'];

// Sanitize the form data
$email = mysqli_real_escape_string($db, $email);

$sql = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
$result = mysqli_query($db, $sql);
$count = mysqli_fetch_assoc($result)['count'];

// If the email already exists in the database, display an error message and exit
if ($count > 0) {
  header( 'Location: index3.html');
  exit;
}

// Create an SQL INSERT statement to insert the form data into the database
$sql = "INSERT INTO users (email) VALUES ('$email')";

// Execute the SQL INSERT statement
$result = mysqli_query($db, $sql);

// Check if the insert was successful
if ($result === false) {
    echo 'Error inserting data into the database.';
} else {
    header( 'Location: index2.html');
}

// Close the connection to the MySQL database
mysqli_close($db);

?>

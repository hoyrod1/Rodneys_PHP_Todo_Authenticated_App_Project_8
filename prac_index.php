<?php
// include 'inc/database_functions.php';
include 'inc/bootstrap.php';

//Show the password stored in the database
$dbPassword = use_getUser('test3');
//print_r($dbPassword);
  echo '<p>Stored Username: ' . $dbPassword['username'] . '</p>';
  echo '<p>Stored Hashed Password: ' . $dbPassword['password'] . '</p>';

echo '<strong>-------------------------------- THIS IS A NEW LINE 1 --------------------------------</strong>';

//1. Compare the string 'password' with the password from the database (no match)
if ('password' === $dbPassword['password']) {
    echo "<p>Comparison MATCHES!!!</p>";
} else {
    echo "<p>'password' &nbsp <strong>Does NOT Match &nbsp </strong>". $dbPassword['password'] ."</p>";
}

echo '<strong>-------------------------------- THIS IS A NEW LINE 2 --------------------------------</strong>';

//2. Hash the string 'password' with the Bcrypt algarithm, using the built in 'password_hash' function
$hashed = password_hash('password', PASSWORD_BCRYPT); //PASSWORD_DEFAULT also works
echo '<p>Hashed Password: &nbsp ' . $hashed . '</p>';
//changes each time, even with the same password

echo '<strong>-------------------------------- THIS IS A NEW LINE 3 --------------------------------</strong>';
//3. Compare the hashed password with the password from the database (no match)
if ($hashed === $dbPassword['password']) {
    echo "<p>Comparison MATCHES!!!</p>";
} else {
    echo "<p>$hashed &nbsp <strong>Does NOT Match</strong> &nbsp ". $dbPassword['password'] ."</p>";
}

//4. Use the built in verify_password function to verify the string 'password' matches the password from the database
echo '<strong>-------------------------------- THIS IS A NEW LINE 4 --------------------------------</strong>';
if (password_verify('password', $dbPassword['password'])) {
    echo "<p>Verified PASSWORDS MATCH!!!</p>";
} else {
    echo "<p>password <strong>does NOT verify with</strong>". $dbPassword['password'] ."</p>";
}

echo '<strong>-------------------------------- THIS IS A NEW LINE 5 --------------------------------</strong>';

//5. *BONUS* Use the included saveUser(username, password) function to add a new user
// Always store HASHED passwords!!!
$newUser = 'test3';
$newPassword = 'password3';
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
//echo '<p>New Hashed Password: &nbsp ' . $hashedPassword . '</p>';
saveUser($newUser, $hashedPassword);


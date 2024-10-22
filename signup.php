<?php 
    //to display errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    //database connection
    include("./database/connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $profile = $_POST["profile"];
      $name = $_POST["firstname"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $confirmPassword = $_POST["repeat-password"];
      $user_type = $_POST["user_type"];
  
      // Check if the email already exists using prepared statement
      $stmt = $connForAccounts->prepare("SELECT * FROM `peso_accounts` WHERE email=? LIMIT 1");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
  
      if ($user) {
          // Email exists
          echo "<script>alert('Email already exists. Please use a different email.');</script>";
      } else {
          if ($password === $confirmPassword) {
              // Insert new user
              $stmt = $connForAccounts->prepare("INSERT INTO `peso_accounts`(`image`, `name`, `email`, `password`, `userType`) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $profile, $name, $email, $password, $user_type);
  
              if ($stmt->execute()) {
                  header("Location: index.php");
                  exit(); // Ensure no further code runs
              } else {
                  echo "Error: " . $stmt->error;
              }
          } else {
              echo "<script>alert('Passwords do not match');</script>";
          }
      }
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="./css/style.css">
  <script type="text/javascript" src="./js/validation.js" defer></script>
</head>
<body>
  <div class="wrapper">
    <h1>Signup</h1>
    <p id="error-message"></p>
    <form id="form" action="" method="post">
    <div>
        <label for="profile-input">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm40-160h480L570-480 450-320l-90-120-120 160Z"/></svg>        </label>
        <input type="file" name="profile" id="profile-input">
      </div>
      <div>
        <label for="firstname-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg>
        </label>
        <input type="text" name="firstname" id="firstname-input" placeholder="Firstname">
      </div>
      <div>
        <label for="email-input">
          <span>@</span>
        </label>
        <input type="email" name="email" id="email-input" placeholder="Email">
      </div>
      <div>
        <label for="password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
        </label>
        <input type="password" name="password" id="password-input" placeholder="Password">
      </div>
      <div>
        <label for="repeat-password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
        </label>
        <input type="password" name="repeat-password" id="repeat-password-input" placeholder="Repeat Password">
      </div>

      <input type="hidden" name="user_type" value="peso_user">


      <button type="submit">Signup</button>
    </form>
    <p>Already have an Account? <a href="index.php">login</a> </p>
  </div>
</body>
</html>
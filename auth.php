<?php
session_start();
  $error = false;
  $fp = fopen("./data/users.txt","r");
  $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

  if($username && $password){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;

  while($data = fgetcsv($fp)){
    if( $data[0]==$username && $data[1]==sha1($password) ){
      $_SESSION['loggedin'] = true;
      $_SESSION['user'] = $username;
      $_SESSION['role'] = $data[2];
      header('location:index.php');
    }
  }
  if(!$_SESSION['loggedin']){
    $error = true;
  }
}



  if(isset($_GET['logout'])){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;
    session_destroy();
    header('location:index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Authentication</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
  <style media="screen">
    body{
      margin-top: 30px;
    }
  </style>
</head>
<body>
<div class="conatainer">
  <div class="row">
    <div class="column column-60 column-offset-20">
        <h1>Simple Auth Example</h1>
    </div>
  </div>
  <div class="row">
    <div class="column column-60 column-offset-20">
      <?php
        if(true == $_SESSION['loggedin']){
          echo "Hello admin, Welcome";
        }else{
          echo "Hello Stranger, Login Below";
        }
       ?>
    </div>
  </div>

  <div class="row">
    <div class="column column-60 column-offset-20">
      <?php
      if($error){
        echo "<blockquote>Username and password didn't match</blockquote>";
      }
       ?>
      <?php
       if(false == $_SESSION['loggedin']):
      ?>
          <form method="POST">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" value="">
              <label for="password">Password</label>
              <input type="password" id="password"name="password" value="">
              <button type="submit" class="button-primary" name="button">Login</button>
          </form>
          <?php
          else:
          ?>
          <form action="auth.php?logout=true" method="POST">
            <input type="hidden" name="logout" value="1">
              <button type="submit" class="button-primary" name="button">Log out</button>
          </form>
       <?php
        endif;
       ?>
    </div>
  </div>
</div>



</body>
</html>

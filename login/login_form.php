<?php

@include '../config.php';

session_start();

$_SESSION['name'] = null;
$_SESSION['id'] = null;
$_SESSION['is_admin'] = null;

if(isset($_POST['login'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      $_SESSION['name'] = $row['name'];
      $_SESSION['id'] = $row['id'];

      if($row['user_type'] == 'admin'){
         $_SESSION['is_admin'] = TRUE;
         header("Location: $host$uri/proje/pages/duyurular.php");
      }elseif($row['user_type'] == 'user'){
         $_SESSION['is_admin'] = FALSE;
         header("Location: $host$uri/proje/pages/duyurular.php");
      }
     
   }else{
      $error[] = 'Hatalı email ya da şifre!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş Yap!</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>HOŞ GELDİNİZ</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="E-posta">
      <input type="password" name="password" required placeholder="Şifre">
      <input type="submit" name="login" value="Giriş Yap" class="form-btn">
      <p>Hesabınız yok mu? <a href="register_form.php">Üye Ol!</a></p>
   </form>

</div>

</body>
</html>
<?php

@include '../config.php';

session_start();

if($_SESSION['is_admin'] == FALSE){
    header("Location: $host$uri/proje/login/login_form.php");
}

$id = $_GET["id"];
$select = " SELECT * FROM user_form WHERE id = '$id'";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_array($result);
$username = $row["name"]; 
$email = $row["email"]; 


if(isset($_POST['update'])){

   $name = $_POST['user_name'];
   $mail = $_POST['user_email'];
   $update = "UPDATE user_form SET name = '$name', email = '$mail' WHERE id = '$id'";
        mysqli_query($conn, $update);
        header('location:uyeler.php');

};

if(isset($_POST['delete'])){
   
   $delete = "DELETE from user_form WHERE id = '$id'";
        mysqli_query($conn, $delete);
        header('location:uyeler.php');

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş Yap</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../login/css/style.css">

</head>
<body>
   
<div class="form-container">

<form action="" method="post">
<input type="text" name="user_name" value= <?php
   if(isset($username)){
      
         echo "$username";
   };
   ?> required placeholder="Üye adı"> </br>
      <input type="text" name="user_email" required placeholder="E-mail" value =<?php
   if(isset($email)){
      
         echo "$email";
   };
   ?> > </br></br>
      <input type="submit" name="update" value="GÜNCELLE" class="form-btn">
      <input type="submit" name="delete" value="SİL" class="form-btn">
</form>
</div>
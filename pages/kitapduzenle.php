<?php

@include '../config.php';

session_start();

if($_SESSION['is_admin'] == FALSE){
    header("Location: $host$uri/proje/login/login_form.php");
}


$id = $_GET["id"];
$select = " SELECT * FROM book WHERE id = '$id'";
$result = mysqli_query($conn, $select);

if(mysqli_num_rows($result) <= 0){
    echo '<p>Kitap yok! </br></br></p>';
}
else{
$row = mysqli_fetch_array($result);
$name = $row["name"]; 
$author = $row["author"]; 
$page = $row["page"];
}

if(isset($_POST['update'])){

   $name = $_POST['name'];
   $author = $_POST['author'];
   $page = $row["page"];
   $update = "UPDATE book SET name = '$name', author = '$author' , page = '$page' WHERE id = '$id'";
        mysqli_query($conn, $update);
        header('location:kitap.php');

};

if(isset($_POST['delete'])){
   
   $delete = "DELETE from book WHERE id = '$id'";
        mysqli_query($conn, $delete);
        header('location:kitap.php');

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
      <input type="text" name="name" required placeholder="Kitap Adı" value = <?php
   if(isset($name)){
      
         echo $name;
   };
   ?>> </br>
      <input type="text" name="author" required placeholder="Yazar" value = <?php
   if(isset($author)){
      
         echo $author;
   };
   ?>></br>
      <input type="number" min="1" name="page" required placeholder="Sayfa" value= <?php
   if(isset($page)){
      
         echo "$page";
   };
   ?>> </br></br>
      <input type="submit" name="update" value="GÜNCELLE" class="form-btn">
      <input type="submit" name="delete" value="SİL" class="form-btn">
</form>
</div>
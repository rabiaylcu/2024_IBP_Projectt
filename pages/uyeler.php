<?php

@include '../config.php';

session_start();

if($_SESSION['is_admin'] == FALSE){
    header("Location: $host$uri/proje/login/login_form.php");
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Üyeler</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/table.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

       <!-- Right navbar links -->
       <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
     
      <li class="nav-item">
        <a  href="../login/login_form.php" role="button">
        <img src="../img/logout.png" alt="logout" width="25" height="25">

        </a>
      </li>
    </ul>
  </nav>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="../img/üyeler.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Üyeler</span>
</div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name'] ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="duyurular.php" class="nav-link">
              <img src="../img/messagel.png" class="nav-icon far fa" width="25" height="25"></img>
              <p>
                Duyurular
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="kitap.php" class="nav-link">
              <img src="../img/book.png" class="nav-icon far fa" width="25" height="25"></img>
              <p>
                Kitaplar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="uyeler.php" class="nav-link">
              <img src="../img/üyeler.png" class="nav-icon far fa" width="25" height="25"></img>
              <p>
                Üyeler
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ayarlar.php" class="nav-link">
              <img src="../img/settings.png" class="nav-icon far fa" width="25" height="25"></img>
              <p>
                Ayarlar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Üyeler</h1>
          </div>
      
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <table>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">İsim</th>
      <th scope="col">Email</th>
      <th scope="col">Tip</th>
      <?php if($_SESSION['is_admin'] == TRUE) : ?>
      <th scope="col">Düzenle</th>
      <?php endif; ?>
    </tr>
  </thead>
  <?php $result = mysqli_query($conn, "SELECT * FROM user_form");
   while ($row = mysqli_fetch_array($result)) {
     $id = $row["id"]; 
     $name = $row["name"]; 
     $email = $row["email"]; 
     $user_type = $row["user_type"]; 
     echo "<tbody>";
     echo "<tr>"; 
     echo "<th>$id</th>"; 
     echo "<th>$name</th>";
      echo "<th>$email</th>";
       echo "<th>$user_type</th>"; 
       if($_SESSION['is_admin'] == TRUE){
        echo "<th>";
        echo "<a  href='uyeduzenle.php?id=$id' role='button'>";
        echo "<img src='../img/edit.jpg' alt='edit' width='25' height='25'>";
        echo "</a></th>";
      }
       echo "</tr>";
       echo "</tbody>";
      }?>
</table>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Rabia YOLCU</strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
</body>
</html>

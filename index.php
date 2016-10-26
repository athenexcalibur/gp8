<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: Ucizi
 * Date: 25/10/16
 * Time: 20:53
 */
?>
<html>
<head>
    <title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/sidebar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="nav navbar-nav">
                <li><a href="#" id="menu-toggle">Menu</a></li>
            </div>

            <div class="navbar-header">
                <a href="index.php" class="navbar-brand">LOGO</a>
            </div>
            <div class="nav navbar-nav navbar-right">
                <li><a href="#">Cart</a></li>
                <li><a href="#">Login</a></li>
            </div>
        </div>
    </nav>

    <div id="wrapper">

        <div id="sidebar-wrapper">
           <ul class="sidebar-nav">
              <li><a href="#">Home</a> </li>
               <li><a href="#">Account</a> </li>
               <li><a href="#">New Listing</a> </li>
               <li><a href="#">About/Contact</a> </li>
           </ul>
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                   <div class="col-lg-12">
                       <h1>Main Content here</h1>
                   </div>
                </div>
            </div>

        </div>
    </div>

    <!-- JQuery Script to toggle menu -->
    <script>
        $("#menu-toggle").click(function (e) {
          e.preventDefault();
            $("#wrapper").toggleClass("drawer-open");
        });
    </script>
</body>
</html>

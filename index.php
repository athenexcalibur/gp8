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
    <link rel="stylesheet" href="bootstrap/css/bootstrap(mod).min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav id="navbar" class="nav navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="nav navbar-nav">
                <li><a href="#" id="menu-toggle">Menu</a></li>
            </div>

            <div class="navbar-header">
                <a href="index.php" class="navbar-brand">LOGO</a>
            </div>
            <div class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
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

                       <!--Main Content here-->
                       <div class="container">
                           <div class="row">
                               <div class="col-sm-3"></div>
                               <div class="col-lg-6">
                                   <form>
                                       <div class="form-group">
                                           <input type="search" class="form-control" placeholder="Search...">
                                           <span class="btn glyphicon glyphicon-search"></span>
                                       </div
                                   </form>
                               </div>
                               <div class="col-sm-3"></div>
                               </div>
                       </div>

                       <!--Item Containers-->
                       <div class="container">
                           <div class="row">
                               <div class="col-sm-4">
                                   <div class="panel panel-primary">
                                       <div class="panel-heading">FOOD</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                               <div class="col-sm-4">
                                   <div class="panel panel-danger">
                                       <div class="panel-heading">Food</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                               <div class="col-sm-4">
                                   <div class="panel panel-success">
                                       <div class="panel-heading">Food</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                           </div>
                       </div><br>

                       <div class="container">
                           <div class="row">
                               <div class="col-sm-4">
                                   <div class="panel panel-primary">
                                       <div class="panel-heading">Food</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                               <div class="col-sm-4">
                                   <div class="panel panel-primary">
                                       <div class="panel-heading">Food</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                               <div class="col-sm-4">
                                   <div class="panel panel-primary">
                                       <div class="panel-heading">Food</div>
                                       <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
                                       <div class="panel-footer">4 miles away</div>
                                   </div>
                               </div>
                           </div>
                       </div><br><br>
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


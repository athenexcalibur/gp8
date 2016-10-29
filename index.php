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
    <link rel="stylesheet" href="css/homepage-content.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

    <div id="wrapper">
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
                    <li><a
                        href="#" title="Login popover"
                        data-toggle="popover" data-trigger="focus"
                        data-placement="bottom"
                        data-content='Login details here'>
                        Login
                    </a></li>
                </div>
            </div>
        </nav>


   <script>
       $(document).ready(function(){
           $('[data-toggle="popover"]').popover();
       });
   </script>

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

                       <!-- SearchBar -->
                       <div class="container">
                           <div class="row">
                               <div class="col-sm-3"></div>
                               <div class="col-sm-6 ">
                                   <form>
                                       <div class="form-group input-group">
                                           <input type="text" class="form-control" placeholder="Search..">
                                           <span class="input-group-btn">
                                               <button class="btn btn-default" type="button">
                                                   <span class="glyphicon glyphicon-search"></span>
                                               </button>
                                           </span>
                                       </div>
                                   </form>
                               </div>
                               <div class="col-sm-3"></div>
                           </div>
                       </div>


                       <!--Item Containers-->
                       <div>
                           <div class="container" id="itemheader">
                               <div class="jumbotron">
                                   <h2>Items near you</h2>
                               </div>
                           </div>
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


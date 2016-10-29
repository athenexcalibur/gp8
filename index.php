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
    <link rel="stylesheet" href="css/popover.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/popover.js"></script>
    <script src="js/navbar.js"></script>
</head>
<body>

    <div id="wrapper">

        <!--Navigation bar on top of Screen-->
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
                    <li><a href="#" rel="details" class="btn btn-small pull-left" data-toggle="popover" title="Login popover" data-content="">
                        Login
                    </a></li>
                </div>
            </div>
        </nav>

        <!-- Modal for creating new account-->
        <div class="modal fade" id="popUpWindow">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Create Account</h3>
                    </div>

                    <!-- body (form) -->
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                        </form>
                    </div>

                    <!-- button -->
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block">Submit</button>
                    </div>

                </div>
            </div>
        </div>

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
                       <!--Main Content goes in here-->

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

</body>
</html>


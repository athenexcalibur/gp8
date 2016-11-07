<!DOCTYPE html>
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
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand">LOGO</a>
                </div>
                <div class="nav navbar-nav navbar-right">

                    <?php
                    require_once("php/membership/userfunctions.php");
                    cSessionStart();

                    if (!loginCheck() || !isset($_SESSION["username"]))
                    {
                        echo '
                        <li><a href="#" class="btn btn-small pull-left" data-toggle="modal" data-target="#login-modal">
                            Login
                        </a></li>';
                    }
                    else
                    {
                        echo '<li><a href="#" id="menu-toggle" class="btn btn-small pull-left">'.
                            'Hello, ' . htmlspecialchars($_SESSION["username"]) .
                        '</a></li>';
                    }
                    ?>
                </div>
            </div>
        </nav>

        <!-- Login Modal -->
        <div class="modal fade" id="login-modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Login</h3>
                    </div>

                    <!-- body (form) -->
                    <div class="modal-body">
                        <form role="form" action="php/membership/login.php" method="post">
                            <div class="form-group">
                                <input name = "email" type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input name = "password" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-block" data-toggle="modal"
                                data-target="#create-ac-modal" data-dismiss="modal">
                            Create Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for creating new account-->
        <div class="modal fade" id="create-ac-modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Create Account</h3>
                    </div>

                    <!-- body (form) -->
                    <div class="modal-body">
                        <form role="form" action="php/membership/register.php" method="post">
                            <div class="form-group">
                                <input name = "email" type="email" class="form-control" placeholder="Email..." required>
                            </div>
                            <div class="form-group">
                                <input name = "username" type="text" class="form-control" placeholder="Username..." required>
                            </div>
                            <div class="form-group">
                                <input name = "password" type="password" class="form-control" placeholder="Password..." required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password...">
                            </div>
                            <button class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar-wrapper">
           <ul class="sidebar-nav">
              <li><a href="#">Home</a> </li>
               <li><a href="#">Account</a> </li>
               <li><a href="#">Cart</a></li>
               <li><a href="#">New Listing</a> </li>
               <li><a href="php/membership/logout.php">Logout</a> </li>
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


<?php
require_once "php/user.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: ./index.php");
    exit;
}
?>
<!DOCTYPE html>
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--snap stuff-->
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <link rel="stylesheet" type="text/css" href="snap/snap.css" />

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

  <!-- Material-Design icon library -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Bootstrap Core Stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/bootstrap.min.css">

  <!-- Material-Design core stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/mdb.min.css">

  <!-- My Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/inbox.css">
  <link rel="stylesheet" href="css/profile.css">

</head>

<body onload="fillThreads()">
  <div class="snap-drawers">
    <div class="snap-drawer snap-drawer-right">
      <div>
        <ul>
          <li>Orders</li>
          <li>Listings</li>
          <li>Messages</li>
          <li>Notifications</li>
          <li>Account</li>
        </ul>
      </div>
    </div>
  </div>
  <div id="content" class="snap-content">
    <header>
      <!-- navbar -->
      <nav class="navbar navbar-dark navbar-fixed-top elegant-color-dark">
        <a href="#" id="open-left" class="navbar-brand">LOGO</a>
        <ul class="nav navbar-nav pull-right">
          <!--<li class="nav-item">-->
          <!--<a class="nav-link">Login</a>-->
          <!--</li>-->
          <li class="nav-item">
            <a href="#" id="open-right" class="nav-link"><i class="material-icons">account_circle</i></a>
          </li>
        </ul>
      </nav>
      <!--/.navbar -->
    </header>


    <main>

    <div class="container" id="allthreads">
      <div class="row">
        <div class="col-md-6">
	  
	  </div>
	</div>

    </main>


    <footer>

    </footer>
  </div>

  <!--Scripts-->
  <script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-material-design/js/tether.min.js"></script>
  <script src="bootstrap-material-design/js/bootstrap.min.js"></script>
  <script src="bootstrap-material-design/js/mdb.min.js"></script>
  <script src="js/cards.js"></script>

  <script type="text/javascript" src="js/messages/inbox.js"> </script>

  <script type="text/javascript" src="snap/snap.min.js"></script>
  <script type="text/javascript">
var snapper = new Snap({
  element: document.getElementById('content')
});
  </script>
  <!--/.Scripts-->
</body>
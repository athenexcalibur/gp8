<?php
require_once "php/user.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: ./index.php");
    exit();
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

</head>

<body>
    <div class="snap-drawers">
	<div class="snap-drawer snap-drawer-right elegant-color-dark">
	    <ul class="nav flex-column">
		<div class="view overlay hm-white-slight">
		    <li class="nav-item">
			<a class="nav-link" href="orders.php">Orders</a>
			<div class="mask"></div>
		    </li>
		</div>
		<div class="view overlay hm-white-slight">
		    <li class="nav-item">
			<a class="nav-link" href="mylistings.php">Listings</a>
			<div class="mask"></div>
		    </li>
		</div>
		<div class="view overlay hm-white-slight">
		    <li class="nav-item">
			<a class="nav-link" href="inbox.php">Messages</a>
			<div class="mask"></div>
		    </li>
		</div>
		<div class="view overlay hm-white-slight">
		    <li class="nav-item">
			<a class="nav-link" href="#">Notifications</a>
			<div class="mask"></div>
		    </li>
		</div>
		<div class="view overlay hm-white-slight">
		    <li class="nav-item">
			<a class="nav-link" href="profile.php">Account</a>
			<div class="mask"></div>
		    </li>
		</div>
	    </ul>
	</div>
    </div>
  <div id="content" class="snap-content">
    <div class="mask"></div>
    <header>
      <!-- navbar -->
      <nav class="navbar navbar-dark navbar-fixed-top elegant-color-dark">
        <a href = "/">
          <img src="img/Cupboard.png" alt="logo" style="width:100px;height:50px;">
        </a>
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

    <div class="card thread-prototype">
      <a href="messagethread.php?threadname="></a>
      <div class="card-block thread-img">
	<img src="avatar/test.png" alt="">
      </div>
      <div class="card-block">
	<h4 class="card-title"></h4>
	<p class="card-text text-muted message-text"></p>
	<p class="card-text text-right text-muted message-time">yesterday</p>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <h2>Inbox</h2>
      </div>
      <div class="row" id="threadCards">
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
  <script type="text/javascript" src="js/messages/inbox.js"> </script>

  <script type="text/javascript" src="snap/snap.min.js"></script>
  <script type="text/javascript" src="js/sidebar.js"></script>
  <!--/.Scripts-->
</body>

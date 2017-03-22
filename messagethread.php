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
  <link rel="stylesheet" href="css/messages.css">

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
	<a href="/" id="open-left" class="navbar-brand">LOGO</a>
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

    <div class="threadinfo card">
      <div class="container-fluid">
	<div class="row">
	  <div class="col-xs-4">
	    <img src="avatar/test.png" alt="" height="80" width="80">
	  </div>
	  <div class="col-xs-6">
	    <div class="card-block">
	      <h4 class="card-title" id=threadname>Curabitur gravida vestibulum imperdiet.</h4>
	    </div>
	  </div>
	</div>
      </div>
    </div>

      <div id="messageDiv" class="container-fluid">
	<div class="row in-prototype">
	  <div class="col-sm-5"></div>
	  <div class="col-sm-7 ">
	    <div class="card z-depth-0 card-primary message-card message-out">
	      <div class="card-block">
		<p class="card-text white-text">hi
Traditional heading elements are designed to work best in the meat of your page
content. When you need a heading to stand out, consider using a display
heading—a larger, slightly more opinionated heading style.  </p>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="row out-prototype">
	  <div class="col-sm-7">
	    <div class="card z-depth-0 grey lighten-2 message-card message-in">
	      <div class="card-block">
		<p class="card-text">hi</p>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-5">
	  </div>
	</div>
      </div>
    </main>

  </div>
  <!--./snap-content-->

    <footer>
      <!--important ids: sendMsg, message-->
      <nav class="navbar navbar-fixed-bottom navbar-light bg-faded type-box">
	<div class="container-fluid">
	  <div class="row align-items-end">
	    <div class="col-xs-12">
	      <div class="input-group custom-input-group">
		<textarea type="text" class="md-textarea custom-textarea"></textarea>
		<a href="#" class="input-group-addon btn btn-primary btn-lg
		  custom-btn">Send</a>
	      </div>
	  </div>
	</div>
      </div>
      </nav>
    </footer>

  <!--Scripts-->
  <script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-material-design/js/tether.min.js"></script>
  <script src="bootstrap-material-design/js/bootstrap.min.js"></script>
  <script src="bootstrap-material-design/js/mdb.min.js"></script>
  <script src="js/cards.js"></script>

  <script type="text/javascript" src="js/messages/messagethread.js"></script>

  <script type="text/javascript" src="snap/snap.min.js"></script>
  <script type="text/javascript" src="js/sidebar.js"></script>
  <script>
    snapper.on("open", function () {
      $(".type-box").fadeOut();
      console.log("yes");
    });
    snapper.on("close", function () {
      $(".type-box").fadeIn();
      console.log("yes");
    });
  </script>

  <!--/.Scripts-->
</body>

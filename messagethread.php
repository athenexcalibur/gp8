<?php
require_once "php/user.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php?error=" . urlencode("You must be logged in to do that."));
    exit();
}


if (!isset($_GET["name"]))
{
    header("Location: index.php?error=" . urlencode("No name set."));
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
  <link rel="stylesheet" href="css/messages.css">

    <?php echo "<script>window.oname = '" . $_GET["name"] . "';</script>"; ?>

</head>

<body>
  <div class="snap-drawers">
    <div class="snap-drawer snap-drawer-right elegant-color-dark">
      <ul class="nav flex-column">
	<div class="view overlay hm-white-slight">
	  <li class="nav-item">
	    <a class="nav-link" href="orders.php">Orders and Listings</a>
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
      <div class="view overlay hm-white-slight">
          <li class="nav-item">
              <a class="nav-link" href="php/membership/logout.php">Logout</a>
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
	<a href = "index.php">
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

    <div class="threadinfo card">
      <div class="container-fluid">
	<div class="row">
	  <div class="col-xs-1">
	    <img src="avatar/test.png" alt="" height="80" width="80">
	  </div>
	  <div class="col-xs-2">
	    <div class="card-block">
	      <h4 class="card-title" id=threadname></h4>
	    </div>
	  </div>

        <div class="dropdown col-xs-9" id="ddDiv">
            <button class="btn btn-secondary dropdown-toggle pull-right" type="button" id="donateDropdown" data-toggle="dropdown">
                Donate Item
            </button>
            <div class="dropdown-menu dropdown-menu-right" id="dDropdownContainer">
            </div>
        </div>
	</div>
      </div>
    </div>
      <!--protoype for recieved messages-->
      <div class="row in-prototype">
	<div class="col-sm-5"></div>
	<div class="col-sm-7 ">
	  <div class="card z-depth-0 card-primary message-card message-out">
	    <div class="card-block">
	      <p class="card-text msg white-text"></p>
	    </div>
	    <div class="card-footer text-muted time-stamp">
	      2 days ago
	    </div>
	  </div>
	</div>
      </div>
      <!--./protoype for recieved messages-->
      <!--./protoype for sent messages-->
      <div class="row out-prototype">
	<div class="col-sm-7">
	  <div class="card z-depth-0 card-primary grey lighten-2 message-card message-in">
	    <div class="card-block">
	      <p class="card-text msg"></p>
	    </div>
	    <div class="card-footer text-muted time-stamp">
	      2 days ago
	    </div>
	  </div>
	</div>
	<div class="col-sm-5">
	</div>
      </div>
      <!--./protoype for sent messages-->

    <!-- message container: filled with prototypes modified by messagethread.js-->
    <div id="messageDiv" class="container-fluid"></div>

    </main>

  </div>
  <!--./snap-content-->

    <footer>
      <nav class="navbar navbar-fixed-bottom navbar-light bg-faded type-box">
	<div class="container-fluid">
	  <div class="row align-items-end">
	    <div class="col-xs-12">
	      <div class="input-group custom-input-group">
		<textarea id="message" class="md-textarea custom-textarea" type="text"></textarea>
		<a id="sendMsg" class="input-group-addon btn btn-primary btn-lg		  custom-btn" href="#">Send</a>
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

<?php 
require_once "php/user.php";
require_once "php/database.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php?error=" . urlencode("You must be logged in to do that."));
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

    <div class="container">
      <div class="row">
        <div class="col-md-6">
	  <div class="card">
	    <div class="card-block">

	      <h3>Hello</h3>
	      <h2><?php echo($_SESSION["user"]->getUserName()); ?></h2>
	      <div id="ratings-div">
		<h1>Rating: <?php echo($_SESSION["user"]->getRating()); ?>/5</h1>
	      </div>
	      <div id="details-div">
		<div id="score">Your score is <?php echo($_SESSION["user"]->getScore()); ?>!</div>
		<div id="listed-items">You have X items currently listed!</div> <!--todo count currently listed items -->
		<div id="exchanged-items">You have exchanged <?php echo $_SESSION["user"]->getNumber()?> items!</div>
	      </div>

	    </div>
	  </div>
	</div>
	<div class="col-md-6">
	  <div class="card">
	    <div class="card-block">

	      <div class="md-form"> <!--todo make this work -->
		<i class="fa fa-pencil prefix"></i>
		<input type="text" id="fname" class="form-control" name="uname" value="<?php echo $_SESSION["user"]->getUserName()?>">
		<label for="fname">Username</label>
	      </div>
	      <div class="md-form">
		<i class="fa fa-pencil prefix"></i>
		<input type="text" id="femail" class="form-control" name="email" value="<?php echo $_SESSION["user"]->getEmail()?>">
		<label for="femail">Email</label>
	      </div>
	      <div class="md-form">
		<i class="fa fa-pencil prefix"></i>
		<input type="text" id="fpass" class="form-control" name="password">
		<label for="fpass">Password</label>
	      </div>
	      <div class="md-form">
		<i class="fa fa-pencil prefix"></i>
		<input type="text" id="form3" class="form-control">
		<label for="form8">Address</label>
	      </div>
	      <div class="md-form">
		<i class="fa fa-pencil prefix"></i>
		<input type="text" id="form3" class="form-control">
		<label for="form8">Diet</label>
	      </div>

	    </div>
	  </div>
	</div>
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

  <script type="text/javascript" src="snap/snap.min.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
  <!--/.Scripts-->
</body>

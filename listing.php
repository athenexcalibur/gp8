<?php
require_once "php/user.php";
require_once "php/database.php";
cSessionStart();
if (!loginCheck())
{
  header("Location: index.php?error=" . urlencode("You must be logged in to do that."));
  exit();
}

$dbconnection = Database::getConnection();
$postID = intval($_GET["id"]);
$stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, posttime, expiry, visible FROM PostsTable WHERE id=? LIMIT 1");
$stmt->bind_param("i", $postID);
$stmt->bind_result($title, $description, $location, $flags, $posterID, $time, $expiry, $visible); //todo show on map
$stmt->execute();
$stmt->store_result();
$stmt->fetch();

if ($stmt->num_rows <= 0)
{
    header("Location: index.php?error=" . urlencode("Could not find that post."));
    exit();
}

$posterInfo = $_SESSION["info"]->getBasicInfo($posterID);
$distance = $_SESSION["user"]->getLocation()->distanceFrom(new Location($location));
$distance = round($distance, 1);
$isPoster = ($_SESSION["user"]->getUserID() == $posterID);
?>

<!DOCTYPE html>
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--snap stuff-->
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <link rel="stylesheet" type="text/css" href="snap/snap.css"/>

  <!DOCTYPE html>
  <html lang="en">
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
    <link rel="stylesheet" href="css/listing.css">
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
              <a class="nav-link" href="inbox.php">Messages <?php if ($_SESSION["user"]->hasNewMessages()) echo ("<i class='fa fa-circle'></i>");?></a>
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
            <li class="nav-item">
              <a href="#" id="open-right" class="nav-link"><i class="material-icons">account_circle</i> <?php if ($_SESSION["user"]->hasNewMessages()) echo ("<i class='fa fa-circle'></i>");?></a>
            </li>
          </ul>
        </nav>
        <!--/.navbar -->
      </header>
      <main>
        <div class="container">
          <div class="card">
            <div class="card-block">
              <div class="card-title">
                <h1><?php echo $title ?></h1>
              </div>
              <div class="card-subtitle"><?php echo $distance ?> miles away</div>
            </div>
            <div class="row">

              <div class="col-md-4">
                <div class="card-block card-image">
                  <div class="view overlay hm-white-slight z-depth-1">
                    <img class="itemimage" id="card_image" data-itemid=<?php echo
                    $_GET["id"]; ?> >
                    <a id="link" href="#">
                      <div class="mask waves-effect"></div>
                    </a>
                  </div>
                </div>
              </div>

              <?php
              if ($isPoster)
              {
                if ($visible)
                {
                echo('
                <div class="col-md-8">
                <div class="card-block">
                <div class="card light-blue lighten-5">
                <div class="card-block">
                <div class="card-title">
                <h4>Options</h4>
                </div>
                <a href="newpost.php?editing=' . $postID . '"><button type="button" class="btn btn-primary">Edit Post</button> </a>
                <button type="button" class="btn btn-danger" id="deleteBtn" data-pid=' . $postID . '>Delete Post</button>
                </div>
                </div>
                </div>
                </div>
                ');
                }
                else echo('
                <div class="col-md-8">
                <div class="card-block">
                <div class="card light-blue lighten-5">
                <div class="card-block">
                <div class="card-title">
                <h2 class="text-info">You have reserved this item for someone. Please visit <a href="orders.php">your orders page</a> to cancel your reservation.</h2>
                </div>
                </div>
                </div>
                ');
              } else echo
              ('
              <div class="col-md-8">
              <div class="card-block user-info">
              <div class="card light-blue lighten-5">
              <i class="material-icons account-icon">account_circle</i>
              <div class="card-block">
              <div class="card-title">
              <h4>'.$posterInfo["name"].'</h4>
              </div>
              <div class="card-text">rating: ' . $posterInfo["rating"] .' points: ' . $posterInfo["score"] . '</div>
              <a href="messagethread.php?name=' . $posterInfo["name"] . '">
              <button type="button" class="btn btn-primary">Message Poster</button>
              </a>
              </div>
              </div>
              </div>
              </div>
              ');

              ?>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card-block">
                  <blockquote class="blockquote bq-primary">
                    <p class="bq-title">Description</p>
                    <p><?php echo $description?></p>
                  </blockquote>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card-block">
                  <blockquote class="blockquote bq-success">
                    <p class="bq-title">Other Information</p>
                    <dl class="row">
                      <dt class="col-xs-4">Expiry</dt>
                      <dd class="col-xs-8"><?php echo $expiry?></dd>
                      <dt class="col-xs-4">Dietary</dt>
                      <?php
                      $first = true;
                      foreach ($_SESSION["info"]->allergens as $i => $name)
                      {
                        if (($i & $flags) != 0)
                        {
                          if ($first) {
                            $first = false;
                            echo '<dd class="col-xs-8">' . $name . '</dd>';
                          } else {
                            echo '<dd class="col-xs-8 offset-xs-4">' . $name . '</dd>';
                          }
                        }
                      }
                      ?>
                    </dl>
                  </blockquote>
                </div>
              </div>

		<!-- recommendations -->
		    <?php
		    if($isPoster){
		    echo( 			
                    '<div class="col-md-6">
                            <div class="card-block">
                              <blockquote class="blockquote bq-primary">
                                <p class="bq-title">Cupboard Recommendation</p>
                                <p></p>
                              </blockquote>
                            </div>
                          </div>');}
                    ?>
	       
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>

  <script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-material-design/js/tether.min.js"></script>
  <script src="bootstrap-material-design/js/bootstrap.min.js"></script>
  <script src="bootstrap-material-design/js/mdb.min.js"></script>
  <script src="js/cards.js"></script>
  <script src="js/listing.js"></script>
  <script src="js/itemimage.js"></script>
  <script type="text/javascript">fixImgs();</script>

  <script type="text/javascript" src="snap/snap.min.js"></script>
  <script type="text/javascript" src="js/sidebar.js"></script>

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
$stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, posttime, expiry FROM PostsTable WHERE id=? LIMIT 1");
$stmt->bind_param("i", $postID);
$stmt->bind_result($title, $description, $location, $flags, $posterID, $time, $expiry); //todo show on map
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
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
  <link rel="stylesheet" type="text/css" href="snap/snap.css" />

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

    <div class="main-container">
      <div class="col-md-8">
        <div class="card">
          <div class="card-block">
            <h1 id="item-name"><?php echo $title ?></h1>
            <div class = "col-md-2">
              <img src="img/vege-card.jpg" alt="example" width = "140" height = "140" class="img-rounded">
            </div>
            <div class = "col-md-10">
              <h5 id="item-address"><?php echo $distance ?> miles away</h5>
              <!--Account info-->
              <div class = "container">
                  <?php
                  if ($isPoster)
                  {
                      echo ("<button class='btn' id='delBtn' data-pid=" . $postID . ">Delete</button>
                             <a class='btn' id='editBtn' href='post.php?editing=" . $postID . "'>Edit or reserve</a>");
                  }
                  else echo
                  ('
                    <div class = "card">
                      <div class = "card-block">
                        <div class = "col-md-6">
                          <a href="#" id="open-right" class="nav-link"><i class="material-icons">account_circle</i></a>
                        </div>
                        <div class = "col-md-6">
                          <p id = "name">' . $posterInfo["name"] . '</p>
                          <div class = "col-md-4">
                            <p id = "rating">' . $posterInfo["rating"] .'</p>
                          </div>
                          <div class = "col-md-8">
                            <p id = "score">' . $posterInfo["score"] . '</p>
                          </div>
                        </div>
                      </div>
                        <a href="messagethread.php?name=' . $posterInfo["name"] . '"class="btn">Message poster</a>
                    </div>
                  </div>');
              ?>
            </div>
            <div class = "col-md-10">
              <table>
                <tr>
                  <td>Use BY</td>
                  <td id = "expiry"><?php echo $expiry?></td>
                </tr>
                <tr>
                  <td>Allergens</td>
                    <?php
                    foreach ($_SESSION["info"]->allergens as $i => $name)
                    {
                        if (($i & $flags) != 0)
                        {
                            echo "<td id='allergen'>" . $name . "</td>";
                        }
                    }
                    ?>
                </tr>
              </table>
              <p id="notes"> "<?php echo $description?>"</p>
            </div>
          </div>
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

<script type="text/javascript" src="snap/snap.min.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
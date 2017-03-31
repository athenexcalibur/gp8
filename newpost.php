<?php
require_once(__DIR__ . "/php/database.php");
require_once(__DIR__ . "/php/user.php");
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php?error=" . urlencode("You must be logged in to do that."));
    exit();
}

$user = $_SESSION["user"];
$allergens = array();
if (isset($_GET["editing"]))
{
    $dbconnection = Database::getConnection();
    $postID = intval($_GET["editing"]);
    $stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, posttime, expiry FROM PostsTable WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $postID);
    $stmt->bind_result($title, $description, $location, $flags, $posterID, $time, $expiry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
    if ($_SESSION["user"]->getUserID() !== $posterID) die("Wrong user ID.");

    for ($i = 1; $i <= 128; $i *= 2) $allergens[$i] = ($flags & $i);

    echo ("<script>window.currentlatLng ='" . $location . "'; window.editing=" . $_GET["editing"] . "</script>");
}

else
{
    for ($i = 1; $i <= 128; $i *= 2) $allergens[$i] = $user->checkFlag($i);

    echo ("<script>window.currentlatLng ='" . $user->getLocation()->getLatLong() . "'</script>");
    /*
    $vegan = ($_SESSION["user"]->checkFlag(VEGAN));
    $vege = ($_SESSION["user"]->checkFlag(VEGETARIAN));
    $peanut = ($_SESSION["user"]->checkFlag(PEANUT));
    $soy = ($_SESSION["user"]->checkFlag(SOY));
    $gluten = ($_SESSION["user"]->checkFlag(GLUTEN));
    $lactose = ($_SESSION["user"]->checkFlag(LACTOSE));
    $halal =  ($_SESSION["user"]->checkFlag(HALAL));
    $kosher = ($_SESSION["user"]->checkFlag(KOSHER));*/
}
?>

<!DOCTYPE html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="dates/bootstrap-material-datetimepicker.css" />

    <!--snap stuff-->
    <meta http-equiv="x-ua-compatible" content="IE=edge"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <link rel="stylesheet" type="text/css" href="snap/snap.css"/>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Material-Design icon library -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap Core Stylesheet -->
    <link rel="stylesheet" href="bootstrap-material-design/css/bootstrap.min.css">

    <!-- Material-Design core stylesheet -->
    <link rel="stylesheet" href="bootstrap-material-design/css/mdb.min.css">

    <!-- My Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/search.css">

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

    <div class = "container">
    <h3>Post a new item</h3>
    <div class = "row">

    <div class = "col-md-6">
    <p>
    <p>
        Title: <input type="text" id="title" <?php if(isset($title)) echo ("value='" . $title . "'");?>><br><br>
        Description: <input type="text" id="description" <?php if(isset($description)) echo ("value='" . $description . "'");?>><br><br>
        Flags (Check all that apply):
        <br>
    <div id="allergyDiv">
        <input type="checkbox" value="VEGAN" <?php if ($allergens[VEGAN]) { echo("checked"); }?>> Vegan <br/>
        <input type="checkbox" value="VEGETARIAN" <?php if ($allergens[VEGETARIAN]) { echo("checked"); }?>> Vegetarian <br/>
        <input type="checkbox" value="PEANUT" <?php if ($allergens[PEANUT]) { echo("checked"); }?>> Peanuts <br/>
        <input type="checkbox" value="SOY" <?php if ($allergens[SOY]) { echo("checked"); }?>> Soy <br/>
        <input type="checkbox" value="GLUTEN" <?php if ($allergens[GLUTEN]) { echo("checked"); }?>> Gluten <br/>
        <input type="checkbox" value="LACTOSE" <?php if ($allergens[LACTOSE]) { echo("checked"); }?>> Lactose <br/>
        <input type="checkbox" value="HALAL" <?php if ($allergens[HALAL]) { echo("checked"); }?>> Halal <br/>
        <input type="checkbox" value="KOSHER" <?php if ($allergens[KOSHER]) { echo("checked"); }?>> Kosher <br/>
    </div>
    <br>
    <br>
    Expiry Date:
    <input type="text" id="date" class="form-control floating-label">

    Upload Image: <input type="image" name="food_image" id="upload_image ">
    <input type="submit" value="Upload Image" name="submit"><br><br>
    </div>

    <div class="col-md-6">
    <input id="addressInput" class="controls" type="text" placeholder="Search...">
    <div id="inputMap" style="width: 500px; height: 500px;"></div>
    <script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
    <script src="js/enterLocation.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIMtO0_uKM_0og7IjdV7nBDjH4dtUmVoY&callback=initMap&libraries=places" async defer></script>
    </div>
    </div>
        <button type="submit" id="tSubmit">Post</button>
        </div>
</main>

    <footer></footer>
</div>

<!--Scripts-->
<script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
<script src="bootstrap-material-design/js/tether.min.js"></script>
<script src="bootstrap-material-design/js/bootstrap.min.js"></script>
<script src="bootstrap-material-design/js/mdb.min.js"></script>
<script src="dates/moments.js"></script>
<script src="dates/bootstrap-material-datetimepicker.js"></script>
<script src="js/search.js"></script>

<script>
    //todo make expiry field load into date
    $("#date").bootstrapMaterialDatePicker({format:"DD/MM/YYYY", weekStart : 0, time: false,  minDate : new Date()});

    $("#tSubmit").on("click", function()
    {
        var checked = [];
        $("#allergyDiv").find("input:checked").each(function()
        {
            checked.push($(this).attr("value"));
        });

        var data =
        {
            title: $("#title").val(),
            description: $("#description").val(),
            flags: checked,
            location: window.currentlatLng.toString(),
            expiry: $("#date").val()
        };

        if (window.editing) data.id = window.editing;
        $.post("newpost.php", data);
        window.currentlatLng = undefined;
    });
</script>

<script type="text/javascript" src="snap/snap.min.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
<!--/.Scripts-->

<?php
/*
 * If 'id' is set, this file will either update that post or delete it (if 'delete' is set)
 * Otherwise it creates a new post.
 */


$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$dbconnection = Database::getConnection();
if (isset($_POST["id"]))
{
    $postID = intval($_POST["id"]);
    $stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, expiry FROM PostsTable WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $postID);
    $stmt->bind_result($title, $description, $location, $flags, $userid, $expiry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
    if ($userid === $_SESSION["user"]->getUserID() && $stmt->num_rows == 1)
    {
        if (isset($_POST["delete"]))
        {
            if (!$dbconnection->query("DELETE FROM PostsTable WHERE id = " . $postID))
            {
                echo ($dbconnection->error);
            }
            exit();
        }
        else
        {
            $title = (isset($_POST["title"])) ? $_POST["title"] : $title;
            $description = (isset($_POST["description"])) ? $_POST["description"] : $description;
            $location = (isset($_POST["location"])) ? $_POST["location"] : $location;
            $expiry = (isset($_POST["expiry"])) ? $_POST["expiry"] : $expiry;

            if (is_array($_POST["flags"]))
            {
                $flags = 0;
                foreach ($_POST["flags"] as $value) $flags |= constant($value);
            }

            $stmt = $dbconnection->prepare("UPDATE PostsTable SET title=?, description=?, location=?, posttime=now(), expiry=?, flags=? WHERE id=?");
            $stmt->bind_param("ssssii", $title, $description, $location, $expiry, $flags, $postID);
            if (!$stmt->execute()) echo $dbconnection->error;
        }
    }
}

else if (isset($_POST["title"]))
{
    $dbconnection = Database::getConnection();

    $flags = 0;
    if (is_array($_POST["flags"]))
    {
        foreach ($_POST["flags"] as $value) $flags |= constant($value);
    }

    $stmt = $dbconnection->prepare("INSERT INTO PostsTable (title, description, expiry, flags, userid, location) VALUES (?, ?, ?, ?, ?, ?)");
    $title = $_POST["title"];
    $descrip =  $_POST["description"];
    $userid = $_SESSION["user"]->getUserID();
    $loc = $_POST["location"];
    $date = str_replace('/', '-', $_POST["expiry"]);
    $date = date('Y-m-d', strtotime($date));
    $stmt->bind_param("sssiis", $title, $descrip, $date, $flags, $userid, $loc);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Your item has been posted");
        else echo("No post made");
    }
    else echo("Post failed");
}
?>

</body>


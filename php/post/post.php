<?php
require_once(__DIR__ . "/../database.php");
require_once(__DIR__ . "/../user.php");
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
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

    for ($i = 1; $i <= 128; $i *= 2)
    {
        if (($flags & $i) != 0) $allergens[$i] = true;
    }

    echo ("<script>window.currentlatLng ='" . $location . "'; window.editing=" . $_GET["editing"] . "</script>");
}

else
{
    for ($i = 1; $i <= 128; $i *= 2)
    {
        if ($user->checkFlag($i)) $allergens[$i] = true;
    }

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


<h3>Post a new item</h3>
<p>
<p>
Title: <input type="text" id="title" <?php if(isset($title)) echo ("value='" . $title . "'");?>><br><br>
Description: <input type="text" id="description" <?php if(isset($description)) echo ("value='" . $description . "'");?>><br><br>
Flags (Check all that apply):
<br>
<div id="allergyDiv">
Vegan? <input type="checkbox" value="VEGAN" <?php if ($allergens[VEGAN]) { echo("checked"); }?>><br/>
Vegetarian? <input type="checkbox" value="VEGETARIAN" <?php if ($allergens[VEGETARIAN]) { echo("checked"); }?>><br/>
Peanuts? <input type="checkbox" value="PEANUT" <?php if ($allergens[PEANUT]) { echo("checked"); }?>><br/>
Soy? <input type="checkbox" value="SOY" <?php if ($allergens[SOY]) { echo("checked"); }?>><br/>
Gluten? <input type="checkbox" value="GLUTEN" <?php if ($allergens[GLUTEN]) { echo("checked"); }?>><br/>
Lactose? <input type="checkbox" value="LACTOSE" <?php if ($allergens[LACTOSE]) { echo("checked"); }?>><br/>
Halal? <input type="checkbox" value="HALAL" <?php if ($allergens[HALAL]) { echo("checked"); }?>><br/>
Kosher? <input type="checkbox" value="KOSHER" <?php if ($allergens[KOSHER]) { echo("checked"); }?>><br/>
</div>
<br>
<br>
Expiry date: <input type="date" id="expiry" <?php if(isset($expiry)) echo ("value='" . $expiry . "'");?>><br><br>
Upload Image: <input type="image" name="food_image" id="upload_image"><br><br>
<input type="submit" value="Upload Image" name="submit"><br<br>
<button type="submit" id="tSubmit">Post</button>
<input id="addressInput" class="controls" type="text" placeholder="Search...">
<div id="inputMap" style="width: 500px; height: 500px;"></div>
<script src="../../bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
<script src="../../js/enterLocation.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIMtO0_uKM_0og7IjdV7nBDjH4dtUmVoY&callback=initMap&libraries=places" async defer></script>

<script>
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
            expiry: $("#expiry").val()
        };

        if (window.editing) data.id = window.editing;
        $.post("post.php", data);
        window.currentlatLng = undefined;
    });
</script>

<?php
/*
 * If 'id' is set, this file will either update that post or delete it (if 'delete' is set)
 * Otherwise it creates a new post.
 */


$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$dbconnection = Database::getConnection();
//todo test this (updating/deleting)
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
    $date = date('m-d-Y', strtotime($_POST["expiry"]));
    echo $date;
    $stmt->bind_param("sssiis", $title, $descrip, $date, $flags, $userid, $loc);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Your item has been posted");
        else echo("No post made");
    }
    else echo("Post failed");
}
?>
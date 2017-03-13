<?php
require_once(__DIR__ . "/php/database.php");
require_once(__DIR__ . "/php/user.php");
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post" action="post.php" id="newpost">
<h3>Post a new item</h3>
<p>
<p>
Title: <input type="text" name="title"><br><br>
Description: <input type="text" name="description"><br><br>
Flags (Check all that apply):
<br>
Vegan? <input type="checkbox" name="flags[]" value="VEGAN" <?php echo ($_SESSION["user"]->checkFlag(VEGAN) ? "checked" : "");?>>
Vegetarian? <input type="checkbox" name="flags[]" value="VEGETARIAN" <?php echo ($_SESSION["user"]->checkFlag(VEGETATIAN) ? "checked" : "");?>><br/>
Peanuts? <input type="checkbox" name="flags[]" value="PEANUT" <?php echo ($_SESSION["user"]->checkFlag(PEANUT) ? "checked" : "");?>>
Soy? <input type="checkbox" name="flags[]" value="SOY" <?php echo ($_SESSION["user"]->checkFlag(SOY) ? "checked" : "");?>><br/>
Gluten? <input type="checkbox" name="flags[]" value="GLUTEN" <?php echo ($_SESSION["user"]->checkFlag(GLUTEN) ? "checked" : "");?>>
Lactose? <input type="checkbox" name="flags[]" value="LACTOSE" <?php echo ($_SESSION["user"]->checkFlag(LACTOSE) ? "checked" : "");?>><br/>
Halal? <input type="checkbox" name="flags[]" value="HALAL" <?php echo ($_SESSION["user"]->checkFlag(HALAL) ? "checked" : "");?>>
Kosher? <input type="checkbox" name="flags[]" value="KOSHER" <?php echo ($_SESSION["user"]->checkFlag(KOSHER) ? "checked" : "");?>><br/>
<br>
<br>
Expiry date: <input type="date" name="expiry"><br><br>
Upload Image: <input type="image" name="food_image" id="upload_image"><br><br>
<input type="submit" value="Upload Image" name="submit"><br<br>
<button type="submit">Post</button>
</form>

<?php

$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$dbconnection = Database::getConnection();

if (isset($_POST["title"]))
{
    $dbconnection = Database::getConnection();

    $flags = 0;
    if (is_array($_POST["flags"]))
    {
        foreach ($_POST["flags"] as $value) $flags |= constant($value);
    }

    $stmt = $dbconnection->prepare("INSERT INTO PostsTable (title, description, expiry, flags) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $_POST["title"], $_POST["description"], date('Y-m-d', strtotime($_POST["expiry"])), $flags);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Your item has been posted");
        else echo("No post made");
    }
    else echo("Post failed");
}

/*TODO paste this into listing page
$postID = intval($_GET["id"]);
$stmt->prepare("SELECT title, description, location, flags, userid, posttime, expiry FROM PostsTable WHERE id=? LIMIT 1");
$stmt->bind_param("i", $postID);
$stmt->bind_result($title, $description, $location, $flags, $hisID, $time, $expiry);
$stmt->execute();
$stmt->store_result();
$stmt->fetch();
$otherName = $_SESSION["user"]->idToName($hisID); */
?>
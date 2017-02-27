
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post" action="post.php" id="newpost">
<h3>Post a new item</h3>
<p>
<p>
Title: <input type="text" name="itemname"><br><br>
Description: <input type="text" name="dscription"><br><br>
Flags (Check all that apply):
<br>
<input type="checkbox" name="flag" value="Halal">Halal<br>
<input type="checkbox" name="flag" value="Kosher">Kosher<br>
<input type="checkbox" name="flag" value="Vegan">Vegan<br>
<input type="checkbox" name="flag" value="Vegetarian">Vegetarian<br>
<input type="checkbox" name="flag" value="Peanut">Peanut<br>
<input type="checkbox" name="flag" value="Gluten">Gluten<br>
<input type="checkbox" name="flag" value="Lactose">Lactose<br>
<input type="checkbox" name="flag" value="Soy">Soy
<br>
<br>
Expiry date: <input type="date" name="expiry"><br><br>
Upload Image: <input type="image" name="food_image" id="upload_image"><br><br>
<input type="submit" value="Upload Image" name="submit"><br<br>
<button type="submit">Post</button>
</form>

<?php
require_once(__DIR__ . "/php/database.php");
$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$errorMessage = "";
$dbconnection = Database::getConnection();

if (isset($_POST["newpost"]))
{
    $dbconnection = Database::getConnection();
    $stmt = $dbconnection->prepare("INSERT INTO PostsTable (id, title, description,location,flags,userid,posttime,expiry) VALUES (?, (SELECT id FROM PostsTableTable WHERE userid = ?), ?)");
    $stmt->bind_param("iss", $_SESSION["user"]->getUserID(), $_POST[""], $_POST["newpost"]);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Your item has been posted");
        else echo("No post made");
    }
    else echo("Post failed");
}
?>
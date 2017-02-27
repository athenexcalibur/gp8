<?php
require_once "php/user.php";
require_once "php/database.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    Email: <input type="text" id="email" name="email" value = "<?php echo htmlspecialchars($_SESSION["user"]->getEmail());?>" required> <br/>
    Username: <input type="text" id="username" name="username" value = "<?php echo htmlspecialchars($_SESSION["user"]->getUserName());?>" required> <br/>
    Vegan? <input type="checkbox" name="flags[]" value="VEGAN" <?php echo ($_SESSION["user"]->checkFlag(VEGAN) ? "checked" : "");?>>
    Vegetarian? <input type="checkbox" name="flags[]" value="VEGETARIAN" <?php echo ($_SESSION["user"]->checkFlag(VEGETATIAN) ? "checked" : "");?>><br/>
    Peanuts? <input type="checkbox" name="flags[]" value="PEANUT" <?php echo ($_SESSION["user"]->checkFlag(PEANUT) ? "checked" : "");?>>
    Soy? <input type="checkbox" name="flags[]" value="SOY" <?php echo ($_SESSION["user"]->checkFlag(SOY) ? "checked" : "");?>><br/>
    Gluten? <input type="checkbox" name="flags[]" value="GLUTEN" <?php echo ($_SESSION["user"]->checkFlag(GLUTEN) ? "checked" : "");?>>
    Lactose? <input type="checkbox" name="flags[]" value="LACTOSE" <?php echo ($_SESSION["user"]->checkFlag(LACTOSE) ? "checked" : "");?>><br/>
    Halal? <input type="checkbox" name="flags[]" value="HALAL" <?php echo ($_SESSION["user"]->checkFlag(HALAL) ? "checked" : "");?>>
    Kosher? <input type="checkbox" name="flags[]" value="KOSHER" <?php echo ($_SESSION["user"]->checkFlag(KOSHER) ? "checked" : "");?>><br/>
    <input type="submit"/>
</form>

<?php
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if(isset($_POST["email"]) && isset($_POST["username"]))
{
    $dbconnection = Database::getConnection();
    if ($stmt = $dbconnection->prepare("UPDATE UsersTable SET username=?, email=?, flags=? WHERE id = ?"))
    {
        $stmt->bind_param('ssii', $_SESSION["user"]->getUserName(), $_SESSION["user"]->getEmail(), $_SESSION["user"]->getFlags(), $_SESSION["user"]->getUserID());
        if (is_array($_POST["flags"]))
        {
            $_SESSION["user"]->clearFlags();
            foreach ($_POST["flags"] as $value) $_SESSION["user"]->setFlag(constant($value));
        }
        $stmt->execute();

        if ($stmt->affected_rows == 1)
        {
            echo("Details updated successfully!");
        }
        else echo ("No changes made! " . $stmt->error );
    }
    else echo("Couldn't prepare the update query!");
}
?>


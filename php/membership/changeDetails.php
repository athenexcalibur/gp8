<?php
require_once "../user.php";
require_once "../database.php";

if (!loginCheck())
{
    header("Location: ../../index.php");
    exit;
}?>

<?php
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if($_SESSION["REQUEST_METHOD"] === "POST")
{
    $dbconnection = Database::getConnection();
    $user = $_SESSION["user"];
    if ($stmt = $dbconnection->prepare("UPDATE UsersTable SET username=?, email=?, flags=?, location=? WHERE id = ?"))
    {
        $username = ($_POST["username"])? $_POST["username"] : $user->getUserName();
        $email = ($_POST["email"])? $_POST["email"] : $user->getEmail();
        $flags = ($_POST["location"])? $_POST["location"] : $user->getLocation();
        if (is_array($_POST["flags"]))
        {
            $_SESSION["user"]->clearFlags();
            foreach ($_POST["flags"] as $value) $_SESSION["user"]->setFlag(constant($value));
        }

        $stmt->bind_param('ssisi', $username, $email, $user->getFlags(), $user->getLocation(), $user->getUserID());
        $stmt->execute();

        if ($stmt->affected_rows == 1)
        {
            echo("Details updated successfully!");
        }
        else echo ("No changes made: " . $stmt->error );
    }
    else echo("Couldn't prepare the update query!");
}

/*
 *     Email: <input type="text" id="email" name="email" value = "<?php echo htmlspecialchars($_SESSION["user"]->getEmail());?>" required> <br/>
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
 */
?>


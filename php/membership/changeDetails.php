<?php
//todo hook this up to something

require_once "../user.php";
require_once "../database.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: ../../index.php");
    exit();
}

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
?>


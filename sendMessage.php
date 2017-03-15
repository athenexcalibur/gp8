<?php
require_once "php/user.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="messageform">
        Username: <input type="text" name="usersearch" id="usersearch" required/><br/>
        Message:<br/>
        <textarea name="message" min="5" max="256"></textarea><br/>
        <button type="submit">Send</button>
    </form>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function()
        {
            $("#usersearch").autocomplete
            ({
                source: "php/userAutocomplete.php",
                minLength: 1
            });

        });
    </script>

<?php
require_once "php/database.php";
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if (isset($_POST["usersearch"]))
{
    $dbconnection = Database::getConnection();
    $stmt = $dbconnection->prepare("INSERT INTO MessagesTable (fromid, toid, text) VALUES (?, (SELECT id FROM UsersTable WHERE username = ?), ?)");
    $stmt->bind_param("iss", $_SESSION["user"]->getUserID(), $_POST["usersearch"], $_POST["message"]);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Message sent!");
        else echo("No message sent!");
    }
    else echo("Could not execute statement!");
}
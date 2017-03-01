<?php
require_once "user.php";
require_once "database.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: ../index.php");
    exit;
}

$dbConnection = Database::getConnection();

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if (isset($_POST["toUser"]))
{
    $dbconnection = Database::getConnection();
    $userid = $_SESSION["user"]->getUserID();
    $stmt = $dbconnection->prepare("INSERT INTO MessagesTable (fromid, toid, text) VALUES (?, (SELECT id FROM UsersTable WHERE username = ?), ?)");
    $stmt->bind_param("iss", $userid, $_POST["toUser"], $_POST["message"]);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1) echo("Message sent!");
        else echo("No message sent!");
    }
    else echo("Could not execute statement!");
}

else if(isset($_GET["othername"])) //get list of messages with one person
{
    $otherid = $dbConnection->query("SELECT userid FROM UsersTable WHERE username = " . mysqli_real_escape_string($_GET["othername"]));
    $stmt = $dbConnection->prepare("SELECT fromid, toid, text, messagetime FROM MessagesTable 
                                  WHERE fromid = ? AND toid = ? OR fromid = ? AND toid = ?
                                  ORDER BY messageTime ORDER DESC");
    $stmt->bind_param("iiii", $_GET["otherid"],$_SESSION["user"]->getUserID(),$_SESSION["user"]->getUserID(),$_GET["otherid"]);

    if ($stmt->execute())
    {
        $stmt->bind_result($fromid, $toid, $text. $time);
        $messages = array();
        while ($stmt->fetch())
        {
            $row = array();
            $row["fromname"] = $_SESSION["user"]->idToName($fromid);
            $row["toname"] = $_SESSION["user"]->idToName($toid);
            $row["text"] = $text;
            $row["time"] = $time;
        }

        header("Content-Type: application/json");
        echo json_encode($messages);
    }

    else header("Location: ../index.php?error=" . urlencode("Error preparing message thread statement!"));
}

else //no other user specified, return all users and the first message
{
    $stmt = $dbConnection->prepare("SELECT least(fromid, toid) as fromid, greatest(fromid, toid) as toid  FROM MessagesTable 
                                  WHERE fromid = ? OR toid = ?
                                  GROUP BY least(fromid, toid), greatest(fromid, toid)
                                  ORDER BY messageTime DESC");

    $userid = $_SESSION["user"]->getUserID();
    $stmt->bind_param("ii", $userid,$userid);

    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        //$stmt->bind_result($fromid, $toid);
        $messages = array();
        while ($data = $result->fetch_assoc())
        {
            $fromid = $data["fromid"];
            $toid = $data["toid"];

            $row = array();
            $row["fromname"] = $fromid === $userid ? $_SESSION["user"]->idToName($toid) : $_SESSION["user"]->idToName($fromid);

            $stmt2 = $dbConnection->prepare("SELECT text, UNIX_TIMESTAMP(messagetime) AS time FROM MessagesTable 
                                  WHERE fromid = ? AND toid = ? OR toid = ? AND fromid = ?
                                  ORDER BY time DESC LIMIT 1");
            $stmt2->bind_param("iiii", $fromid, $toid, $fromid, $toid);
            $stmt2->bind_result($text, $time);
            $stmt2->execute();
            $stmt2->fetch();
            $row["text"] = $text;
            $row["time"] = $time;
            $stmt2->close();
            $messages[] = $row;
        }

        header("Content-Type: application/json");
        echo json_encode($messages);
    }

    else header("Location: ../index.php?error=" . urlencode("Error preparing message list statement!"));

}
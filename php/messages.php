<?php
require_once "user.php";
require_once "database.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}

$dbConnection = Database::getConnection();

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

else if(isset($_GET["otherid"])) //get list of messages with one person
{
    $stmt = $dbConnection->prepare("SELECT fromid, toid, text, messagetime FROM MessagesTable 
                                  WHERE fromid = ? AND toid = ? OR fromid = ? AND toid = ?
                                  ORDER BY messageTime ORDER DESC");
    $stmt->bind_param("iiii", $_GET["otherid"],$_SESSION["user"]->getUserId(),$_SESSION["user"]->getUserId(),$_GET["otherid"]);

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
    $stmt->bind_param("ii", $_SESSION["user"]->getUserId(),$_SESSION["user"]->getUserId());

    if ($stmt->execute())
    {
        $stmt->bind_result($fromid, $toid);
        $messages = array();
        while ($stmt->fetch())
        {
            $row = array();
            $row["fromname"] = $fromid === $_SESSION["user"]->getUserID() ? $_SESSION["user"]->idToName($toid) : $_SESSION["user"]->idToName($fromid);

            $stmt2 = $dbConnection->prepare("SELECT text, time FROM MessagesTable 
                                  WHERE fromid = ? AND toid = ? OR toid = ? AND fromid = ? 
                                  ORDER BY messageTime ORDER DESC LIMIT 1");
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
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

if(isset($_GET["otherid"])) //get list of messages with one person
{
    $stmt = $dbConnection->prepare("SELECT fromid, toid, text, messagetime FROM MessagesTable 
                                  WHERE fromid = ? AND toid = ? OR fromid = ? AND toid = ?
                                  ORDER BY messageTime ORDER DESC");
    $stmt->bind_param("iiii", $_GET["otherid"],$_SESSION["user"]->getUserId(),$_SESSION["user"]->getUserId(),$_GET["otherid"]);

    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $messages = array();
        while ($row = $result->fetch_assoc())
        {
            $row["fromname"] = $_SESSION["user"]->idToName($row["fromid"]);
            $row["toname"] = $_SESSION["user"]->idToName($row["toid"]);
            $messages[] = $row;
        }

        header("Content-Type: application/json");
        echo json_encode($messages);
    }

    else header("Location: ../index.php?error=" . urlencode("Error preparing message thread statement!"));
}

else //no other user specified, return all users
{
    $stmt = $dbConnection->prepare("SELECT fromid, toid FROM MessagesTable 
                                  WHERE fromid = ? OR toid = ?
                                  ORDER BY messageTime ORDER DESC");
    $stmt->bind_param("ii", $_SESSION["user"]->getUserId(),$_SESSION["user"]->getUserId());

    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $names = array();
        while ($row = $result->fetch_assoc())
        {
            $row["fromname"] = $_SESSION["user"]->idToName($row["fromid"]);
            $row["toname"] = $_SESSION["user"]->idToName($row["toid"]);
            $messages[] = $row;
        }

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    else header("Location: ../index.php?error=" . urlencode("Error preparing message list statement!"));

}
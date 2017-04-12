<?php
require_once (__DIR__ . "/../database.php");

cSessionStart();
if (!loginCheck())
{
    header("Location: ../../index.php");
    exit();
}

function notifyUser($notification, $userid)
{
    $cnx = Database::getConnection();
    $stmt = $cnx->prepare("INSERT INTO NotificationTable(toid, text) VALUES (?,?)");
    $stmt->bind_param("is", $userid, $notification);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $cnx = Database::getConnection();
    $stmt = $cnx->prepare("SELECT text FROM NotificationTable WHERE toid=?");
    $stmt->bind_param("i", $_SESSION["user"]->getUserID());
    $stmt->bind_result($text);
    $stmt->execute();
    $ret = array();
    while ($stmt->fetch()) $ret[] = $text;
    echo json_encode($ret);
}
?>

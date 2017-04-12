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

    //check if we have more than 20 notifications - delete oldest one
    $res = $cnx->prepare("SELECT * FROM NotificationTable WHERE toid=" . intval($userid));
    if ($res->num_rows > 20) $cnx->prepare("DELETE FROM NotificationTable WHERE notificationtime IS NOT NULL 
                                            ORDER BY notificationtime DESC LIMIT 1");
}

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $cnx = Database::getConnection();
    $uid = $_SESSION["user"]->getUserID();
    $stmt = $cnx->prepare("SELECT text FROM NotificationTable WHERE toid=?");
    $stmt->bind_param("i", $uid);
    $stmt->bind_result($text);
    $stmt->execute();
    $ret = array();
    while ($stmt->fetch()) $ret[] = $text;
    echo json_encode($ret);
}
?>

<?php
require_once "../database.php";
require_once "../user.php";

if(isset($_GET["term"], $_GET["pid"]))
{
    $dbconnection = Database::getConnection();
    $stmt = $dbconnection->prepare("SELECT u.username FROM UsersTable AS u INNER JOIN InterestedTable AS i  ON u.id = i.userID
                                    WHERE u.username LIKE ? AND i.postid = ?");
    $searchstring = $_GET["term"] . "%";
    $stmt->bind_param("si", $searchstring, intval($_GET["pid"]));
    $stmt->bind_result($username);
    $stmt->execute();
    $stmt->store_result();
    $usernames = array();
    while ($stmt->fetch()) $usernames[] = htmlspecialchars($username);
    echo json_encode($usernames);
}
?>
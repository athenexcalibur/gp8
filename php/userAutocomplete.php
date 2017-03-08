<?php
require_once "database.php";
require_once "user.php";

if(isset($_GET["term"]))
{
    $dbconnection = Database::getConnection();
    $stmt = $dbconnection->prepare("SELECT username FROM UsersTable WHERE username LIKE ?");
    $searchstring = $_GET["term"] . "%";
    $stmt->bind_param("s", $searchstring);
    $stmt->execute();
    $result = $stmt->get_result();
    $usernames = array();
    while ($row = $result->fetch_assoc())
    {
        $usernames[] = htmlspecialchars($row["username"]);
    }

    echo json_encode($usernames);
}
?>
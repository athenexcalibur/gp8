<?php
require_once "../database.php";

if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    $cnx = Database::getConnection();
    $result = $cnx->query("SELECT title, description, posttime FROM PostsTable ORDER BY posttime LIMIT 9");
    $ret = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) $ret[] = $row;
    echo json_encode($ret);
}
?>
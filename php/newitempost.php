<?php
/*
 * If 'id' is set, this file will either update that post or delete it (if 'delete' is set)
 * Otherwise it creates a new post.
 */

require_once(__DIR__ . "/database.php");
require_once(__DIR__ . "/user.php");
require_once(__DIR__ . "/notifications/notifyUser.php");
cSessionStart();

$_POST = array();
parse_str(file_get_contents('php://input'), $_POST);

$dbconnection = Database::getConnection();
if (isset($_POST["id"]))
{
    $postID = intval($_POST["id"]);
    $stmt = $dbconnection->prepare("SELECT title, description, location, flags, userid, expiry FROM PostsTable WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $postID);
    $stmt->bind_result($title, $description, $location, $flags, $userid, $expiry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
    if ($userid === $_SESSION["user"]->getUserID() && $stmt->num_rows == 1)
    {
        if (isset($_POST["delete"]))
        {
            if (!$dbconnection->query("DELETE FROM PostsTable WHERE id = " . $postID))
            {
                echo json_encode(array("error" => $dbconnection->error));
            }
            exit();
        }
        else
        {
            $title = (isset($_POST["title"])) ? $_POST["title"] : $title;
            $description = (isset($_POST["description"])) ? $_POST["description"] : $description;
            $location = (isset($_POST["location"])) ? $_POST["location"] : $location;
            $expiry = (isset($_POST["expiry"])) ? $_POST["expiry"] : $expiry;

            if (is_array($_POST["flags"]))
            {
                $flags = 0;
                foreach ($_POST["flags"] as $value) $flags |= constant($value);
            }

            $stmt = $dbconnection->prepare("UPDATE PostsTable SET title=?, description=?, location=?, posttime=now(), expiry=?, flags=? WHERE id=?");
            $stmt->bind_param("ssssii", $title, $description, $location, $expiry, $flags, $postID);
            if (!$stmt->execute()) echo json_encode(array("error" => $dbconnection->error));
            else
            {
              echo json_encode(array("postid" => $postID));
            }
        }
    }
}

else if (isset($_POST["title"]))
{
    $dbconnection = Database::getConnection();

    $flags = 0;
    if (is_array($_POST["flags"]))
    {
        foreach ($_POST["flags"] as $value) $flags |= constant($value);
    }

    $stmt = $dbconnection->prepare("INSERT INTO PostsTable (title, description, expiry, flags, userid, location) VALUES (?, ?, ?, ?, ?, ?)");
    $title = $_POST["title"];
    $descrip =  $_POST["description"];
    $userid = $_SESSION["user"]->getUserID();
    $loc = $_POST["location"];
    $date = str_replace('/', '-', $_POST["expiry"]);
    $date = date('Y-m-d', strtotime($date));
    $stmt->bind_param("sssiis", $title, $descrip, $date, $flags, $userid, $loc);
    if ($stmt->execute())
    {
        if ($stmt->affected_rows === 1)
        {
            $postid = $dbconnection->insert_id;

            //notify everyone looking for stuff here
            $everything = $dbconnection->query("SELECT * FROM ReservedTable");
            $titleU = strtoupper($title);
            $descU = strtoupper($descrip);
            while ($row = mysqli_fetch_array($everything, MYSQLI_ASSOC))
            {
                if (strpos($titleU, $row["word"]) != 0 || strpos($descU, $row["word"]) != 0)
                {
                    notifyUser("A new post (link) contains your reserved word '" . strtolower($row["word"]) . "'", $row["userid"]); //todo
                }
            }

            echo json_encode(array("postid" => $postid));
        } else echo json_encode(array("error" => "No post made"));
    }
    else echo json_encode(array("error" => "Post failed"));
}
?>

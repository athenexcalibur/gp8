<?php
require_once "user.php";
require_once "database.php";

cSessionStart();
if (!loginCheck())
{
    header("Location: ../index.php");
    exit;
}

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);
$dbConnection = Database::getConnection();

/*
 * If the poster is finalizing "otherID" must be set
 * In all cases "postID" and "rating" must be set
 */

if(isset($_POST["postID"]) && isset($_POST["rating"]))
{
	$userid = intval($_SESSION["user"]->getUserID());

	$stmt = $dbConnection->prepare("SELECT userid FROM PostsTable WHERE id=?");
	$stmt->bind_param("i", intval($_POST["postID"]));
	$stmt->bind_result($posterid);
	$stmt->execute();
	
	if ($stmt->affected_rows != 1) recipientFinalise(intval($_POST["postID"]));
	
	$stmt->fetch();
	
	if ($userid !== $posterid)
	{
		$stmt->close();
		die("Only the poster can begin to finalize this post!");
	}
	
	$stmt = $dbConnection->prepare("SELECT title, description, expiry FROM PostsTable WHERE id=?");
	$stmt->bind_param("i", intval($_POST["postID"]));
	$stmt->bind_result($title, $description, $expiry);
	$stmt = $dbConnection->prepare("INSERT INTO FinishedPostsTable (id, title, description, posterID, recipientID, expiry) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("issiis", intval($_POST["postID"]), $title, $description, $userid, intval($_POST["otherID"]), $expiry);
	$stmt->execute();
	
	if ($stmt->affected_rows === 1)
	{
		$dbConnection->multi_query("DELETE FROM PostsTable WHERE id=" . intval(isset($_POST["postID"])
		 . "; UPDATE UsersTable SET score=score+10 WHERE id=". intval($userid)));

		if(isset($_POST["rating"]))
        {
            $result = $dbConnection->query("SELECT number, rating FROM UsersTable WHERE id=" . intval($_POST["otherID"]));
            $result = $result->fetch_assoc();

            $newrating = (floatval($result["rating"]) * $result["number"] + min(0, max($_POST["rating"], 5))) / ($result["number"] + 1);
            $dbConnection->query("UPDATE UsersTable SET number=number+1, rating=" . $newrating . " WHERE id=" . intval($_POST["otherID"]));
        }
        else echo "No rating recieved.";
		echo "It worked!"; //todo
	}
	else die ($dbConnection->mysql_error);
}

/*
 * stillUp - array of posts that are still listed
 * waitingForRecepient - posts that you (the poster) have finalized but not the other guy
 * waitingForYou - posts you have not finalized as the recepient
 * bothDone - finished posts
 */
else if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    global $dbConnection;
    $userid = intval($_SESSION["user"]->getUserID());

    //get posts still up
    $stillGoing = array();
    if ($result = $dbConnection->query("SELECT * FROM PostsTable WHERE userid=" . $userid))
    {
        while ($row = $result->fetch_assoc()) $stillGoing[] = $row;
    }

    //get the rest
    $waitingForRecepient = array();
    $waitingForYou = array();
    $bothDone = array();
    if ($result = $dbConnection->query("SELECT * FROM FinishedPostsTable WHERE posterID=" . $userid . " OR recepientID=" . $userid))
    {
        while ($row = $result->fetch_assoc())
        {
            if(intval($row["recepientDone"]) === 1) $bothDone[] = $row;
            else if (intval($row["recepientID"]) === $userid) $waitingForYou[] = $row;
            else $waitingForRecepient = $row;
        }
    }

    $fin = array("stillUp" => $stillGoing, "waitingForRecepient"=>$waitingForRecepient, "waitingForYou"=>$waitingForYou, "bothDone"=>$bothDone);
    echo json_encode($fin);
}

function recipientFinalise($postID)
{
    global $dbConnection;
    $userid = $_SESSION["user"]->getUserID();
    $stmt = $dbConnection->prepare("SELECT recepientID, recepientDone, posterID FROM FinishedPostsTable WHERE id=?");
    $stmt->bind_param("i", intval($postID));
    $stmt->bind_result($recepID, $recepDone, $posterID);
    $stmt->fetch();
    if ($recepID !== $userid) die("Wrong user ID.");
    if ($recepDone) die("Post already finalized.");

    $dbConnection->query("UPDATE FinishedPostsTable SET recepientDone=1 WHERE id=" . intval($postID));
    $dbConnection->query("UPDATE UsersTable SET score=score+1 WHERE id=". intval($userid));

    if (is_numeric($_POST["rating"]))
    {
        $stmt = $dbConnection->prepare("SELECT number, rating FROM UserdTable WHERE id=?");
        $stmt->bind_param("i", $posterID);
        $stmt->bind_result($number, $rating);
        $stmt->execute();
        $stmt->fetch();

        $newrating = (($rating + floatval($_POST["rating"])) / ($number + 1));
        $dbConnection->query("UPDATE UsersTable SET number=number+1, rating=" . floatval($newrating) . " WHERE id=" . intval($posterID));
    }

}

?>
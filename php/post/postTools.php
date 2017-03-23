<?php
require_once(__DIR__ . "/../database.php");
require_once(__DIR__ . "/../user.php");
require_once(__DIR__ . "/../location.php");
cSessionStart();
if (!loginCheck())
{
    header("Location: ../index.php");
    exit();
}

$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);
$dbConnection = Database::getConnection();

/*
 * If the poster is finalizing "rating" must be set
 * If he is reserving it for someone "otherID" must be set
 * In all cases "postID" must be set
 */
//todo add option to cancel reservations
//todo test this (not even tested once but needs frontend stuff)
if(isset($_POST["postID"]))
{
	$userid = intval($_SESSION["user"]->getUserID());

	$stmt = $dbConnection->prepare("SELECT userid FROM PostsTable WHERE id=?");
	$stmt->bind_param("i", intval($_POST["postID"]));
	$stmt->bind_result($posterid);
	$stmt->execute();
	if ($stmt->affected_rows != 1) //post is removed from poststable when poster reserves it
    {
        finalise(intval($_POST["postID"]));
        exit();
    }
	$stmt->fetch();
	
	if ($userid !== $posterid)
	{
		$stmt->close();
		die("Only the poster can deal with this post!");
	}

    if (isset($_POST["otherID"]))
    {
        $stmt = $dbConnection->prepare("SELECT title, description, expiry FROM PostsTable WHERE id=?");
        $stmt->bind_param("i", intval($_POST["postID"]));
        $stmt->bind_result($title, $description, $expiry);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();

        $stmt = $dbConnection->prepare("UPDATE PostsTable SET visible=0 WHERE id=?");
        $stmt->bind_param("i", intval($_POST["postID"]));
        $stmt->execute();

        $stmt = $dbConnection->prepare("INSERT INTO FinishedPostsTable (id, title, description, posterID, recipientID, expiry) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issiis", intval($_POST["postID"]), $title, $description, $userid, intval($_POST["otherID"]), $expiry);
        $stmt->execute();
    }
}

/*
 * stillUp - array of your posts that are still listed
 * reserved - posts you have reserved for someone but neither have finalized (cancel here)
 * waitingForYou - posts you have not finalized (rated the other guy)
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
    $reserved = array();
    $waitingForYou = array();
    $bothDone = array();
    if ($result = $dbConnection->query("SELECT * FROM FinishedPostsTable WHERE posterID=" . $userid . " OR recepientID=" . $userid))
    {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $row["posterName"] = $_SESSION["info"]->idToName(intval($row["userid"]));
            if (isset($row["location"]) && ($loc = $_SESSION["user"]->getLocation()))
            {
                $row["distance"] = $loc->distanceFrom(new Location($row["location"]));
            } //ugh

            $rdone = intval($row["recepientDone"]);
            $rid = intval($row["recepientID"]);
            $pdone = intval($row["posterDone"]);
            $pid = intval($row["posterID"]);
            if ($rdone && $pdone) $bothDone[] = $row;
            else if (!$rdone && !$pdone) $reserved[] = $row;
            else if ((!$rdone && $userid == $rid) ||(!$pdone && $userid == $pid)) $waitingForYou[] = $row;
        }
    }

    $fin = array("stillUp" => $stillGoing, "waitingForYou"=>$waitingForYou, "bothDone"=>$bothDone, "reserved"=>$reserved);
    echo json_encode($fin);
}


function finalise($postID)
{
    global $dbConnection;
    $userid = $_SESSION["user"]->getUserID();
    $stmt = $dbConnection->prepare("SELECT recepientID, recepientDone, posterID, posterDone FROM FinishedPostsTable WHERE id=?");
    $stmt->bind_param("i", intval($postID));
    $stmt->bind_result($recepID, $recepDone, $posterID, $posterDone);
    $stmt->fetch();
    if ($recepID == $userid)
    {
        if ($recepDone) die("Post already finalized.");
        $dbConnection->query("UPDATE FinishedPostsTable SET recepientDone=1 WHERE id=" . intval($postID));
        $dbConnection->query("UPDATE UsersTable SET score=score+1 WHERE id=". intval($userid));
        $otherid = $posterID;
        $otherb = $posterDone;
    }
    else if ($posterID == $userid)
    {
        if ($posterDone) die("Post already finalized.");
        $dbConnection->query("UPDATE FinishedPostsTable SET posterDone=1 WHERE id=" . intval($postID));
        $dbConnection->query("UPDATE UsersTable SET score=score+5 WHERE id=". intval($userid));
        $otherid = $recepID;
        $otherb = $recepDone;
    }
    else die("Wrong user ID.");

    $stmt = $dbConnection->prepare("SELECT number, rating FROM UsersTable WHERE id=?");
    $stmt->bind_param("i", $otherid);
    $stmt->bind_result($number, $rating);
    $stmt->execute();
    $stmt->fetch();

    $newrating = (($rating + floatval($_POST["rating"])) / ($number + 1));
    $dbConnection->query("UPDATE UsersTable SET number=number+1, rating=" . floatval($newrating) . " WHERE id=" . intval($otherid));

    if ($otherb) $dbConnection->query("DELETE FROM InterestedTable WHERE postID=" .intval($postID));
}
?>
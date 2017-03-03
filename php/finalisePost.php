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

if(isset($_POST["postID") && isset($_POST["otherID") $$ isset($_POST["rating"]))
{
	$user = $_SESSION["user"];
	$userid = $user->getUserID();
	
	$dbConnection = Database::getConnection();
	$stmt = $dbConnection->prepare("SELECT userid FROM PostsTable WHERE id=?");
	$stmt->bind_param("i", intval($_POST["postID"));
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
	$stmt->bind_param("i", intval($_POST["postID"));
	$stmt->bind_result($title, $description, $expiry);
	$stmt = $dbConnection->prepare("INSERT INTO FinishedPostsTable (id, title, description, posterID, recipientID, expiry) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("issiis", intval($_POST["postID"), $title, $description, $userid, intval($_POST["otherID")) $expiry);
	$stmt->execute();
	
	if ($stmt->affected_rows === 1)
	{
		$dbConnection->multi_query("DELETE FROM PostsTable WHERE id=" . intval(isset($_POST["postID")
		 . ";UPDATE UsersTable SET score=score+10, number=number+1 WHERE id=".$userid));
		$result = $dbConnection->query("SELECT number, rating FROM UsersTable WHERE id=" . $intval($_POST["otherID"]))
		$result = $result->fetch_assoc();
		
		$newrating = ($result["rating"] * $result["number"] + min(0, max($_POST["rating"], 5))) / ($result["number"] + 1);
		$dbConnection->query("UPDATE UsersTable SET number=number+1, rating=" . $newrating . " WHERE id=" . $intval($_POST["otherID"]));
		echo "It worked!"; //todo
	}
	else die ($dbConnection->mysql_error);
}

function recipientFinalise($postID)
{
	//todo
}

?>
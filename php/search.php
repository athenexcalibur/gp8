<?php
require_once(__DIR__ . "/database.php");
require_once(__DIR__ . "/user.php");
cSessionStart();
if (!loginCheck())
{
    header("Location: post/mostRecent.php");
    exit;
}

$dbconnection = Database::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $keywords = isset($_GET["keywords"]) ? explode(" ", $_GET["keywords"]) : array();
    $location = isset($_GET["location"]) ? $_GET["location"] : "";
    $flags = isset($_GET["flags"]) ? intval($_GET["flags"]) : 0;
	
    $location = mysqli_real_escape_string($dbconnection, $location);

    $sql = "SELECT title,description,location,flags,posttime,expiry,id FROM PostsTable WHERE";
    if (sizeof($keywords) != 0)
    {
        $filtered = mysqli_real_escape_string($dbconnection, $keywords[0]);
        $sql .= "(description LIKE %" . $filtered . "% OR title LIKE %" . $filtered . "%";
        for ($i = 1; $i < sizeof($keywords); $i++)
        {
            $filtered = mysqli_real_escape_string($dbconnection, $keywords[$i]);
            $sql .= " OR description LIKE %" . $filtered . "% OR title LIKE %" . $filtered . "%";
        }
        $sql .= ") AND";
    }
    $sql .= " visible=1";
    $result = $dbconnection->query($sql);

    $out = array();
    $uflags = $_SESSION["user"]->getFlags();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $uLoc = $_SESSION["user"]->getLocation();
        if (areCompatible($uflags, intval($row["flags"])) == 0)
        {
            $row["distance"] = $uLoc->distanceFrom(new Location($row["location"]));
            $out[] = $row;
        }
    }
    echo json_encode($out);
}
?>
<?php
require_once "database.php";

function cSessionStart()
{
    if(session_id() !== '') return true;
    if (ini_set("session.use_only_cookies", 1) === FALSE) return false;
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        false,true);

    session_start();
    session_regenerate_id(true);
    return true;
}

function loginCheck()
{
    return (isset($_SESSION) && isset($_SESSION["user"])) ? true : false;
}

function areCompatible($fromFlags, $toFlags)
{
    return ($fromFlags & ~$toFlags == 0) ? true : false; //php
}

if (isset($_GET["id"]))
{
    if (loginCheck()) echo $_SESSION["user"]->idToName($_GET["id"]);
}

class User
{
    private $username;
    private $userid;
    private $email;
    private $flags;
    private $score;
    private $rating;
    private $location;

    public function __construct($email, $password)
    {
        $dbconnection = Database::getConnection();
        if ($stmt = $dbconnection->prepare
        (
            "SELECT id, username, password, 
             CAST(flags as unsigned integer),
             location, rating, score
             FROM UsersTable
             WHERE email = ?
             LIMIT 1"))
        {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userID, $username, $dbPassword, $this->flags, $this->location, $this->rating, $this->score);
            $stmt->fetch();

            $hash = hash("sha256", $password);

            if ($stmt->num_rows == 1 && $hash === $dbPassword)
            {
                $this->userid = intval(preg_replace("/[^0-9]+/", "", $userID));
                $this->username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                $this->email = $email;
                if(!is_null($this->location)) $this->location = htmlspecialchars($this->location);
            }
            else throw new Exception("Invalid email or password, please try again.");
        } else throw new Exception("There was an error preparing a statement.");
    }

    public function idToName($userid)
    {
        $userid = intval($userid);
        if ($userid === $this->userid) return $this->username;

        $dbconnection = Database::getConnection();

        $stmt = $dbconnection->prepare("SELECT username FROM UsersTable WHERE id = ?");
        $stmt->bind_param("i", $userid);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1)
        {
            $stmt->bind_result($name);
            $stmt->fetch();
            return $name;
        }

        return null;
    }
	
	public function reload()
	{
		$dbconnection = Database::getConnection();
        if ($stmt = $dbconnection->prepare
        (
            "SELECT username, password
             CAST(flags as unsigned integer),
             location, rating, score, email
             FROM UsersTable
             WHERE id = ?
             LIMIT 1"))
        {
            $stmt->bind_param("i", $this->userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($username, $dbPassword, $this->flags, $this->location, $this->rating, $this->score, $this->email);
            $stmt->fetch();

            $this->userid = intval(preg_replace("/[^0-9]+/", "", $this->userid));
            $this->username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
		}
        else throw new Exception("There was an error preparing a statement.");
	}

	public function getScore()
    {
        return $this->username;
    }
	
    public function getUserName()
    {
        return $this->username;
    }
    public function setUserName($username)
    {
        $this->username = htmlspecialchars($username);
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) $this->email = $email;
    }

    public function getUserID()
    {
        return $this->userid;
    }

    public function getLocation()
    {
        if (is_null($this->location)) return "unset";
        else return $this->location;
    }
    public function setLocation($newLoc)
    {
        $this->location = $newLoc;
    }

    public function checkFlag($flag)
    {
        return $this->flags & $flag;
    }

    public function setFlag($flag)
    {
        $this->flags = $this->flags | $flag;
    }

    public function clearFlags()
    {
        $this->flags = 0;
    }

    public function getFlags()
    {
        return $this->flags;
    }
}
<?php
require_once "database.php";

define('VEGAN', 1);
define('VEGETATIAN', 2);
define('PEANUT', 4);
define('SOY', 8);
define('GLUTEN', 16);
define('LACTOSE', 32);
define('HALAL', 64);
define('KOSHER', 128);

function cSessionStart()
{
    if (ini_set("session.use_only_cookies", 1) === FALSE)
    {
        die("Error starting session");
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        false,true);

    session_start();
    session_regenerate_id(true);
}

function loginCheck()
{
    $dbconnection = Database::getConnection();
    if (isset($_SESSION["user"]))
    {
        $user = $_SESSION["user"];
        $userid = $user->getUserID();
        $loginString = $user->getLoginString();
        $userBrowser = $_SERVER["HTTP_USER_AGENT"];

        if ($stmt = $dbconnection->prepare("SELECT password 
                                      FROM UsersTable
                                      WHERE id = ? LIMIT 1"))
        {
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1)
            {
                $stmt->bind_result($password);
                $stmt->fetch();
                $loginCheck = hash("sha512", $password . $userBrowser);

                if (hash_equals($loginCheck, $loginString)) return true;
            }
        }
    }
    return false;
}

class User
{
    private $username;
    private $userid;
    private $email;
    private $loginstring;
    private $flags;
    private $score;
    private $rating;
    private $location;

    public function __construct($email, $password)
    {
        $dbconnection = Database::getConnection();
        if ($stmt = $dbconnection->prepare("SELECT id, username, password, flags, location, rating, score
        FROM UsersTable
        WHERE email = ?
        LIMIT 1"))
        {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userID, $username, $dbPassword, $this->flags, $this->location, $this->rating, $this->score);
            $stmt->fetch();

            if ($stmt->num_rows == 1 && password_verify($password, $dbPassword))
            {
                $this->userid = preg_replace("/[^0-9]+/", "", $userID);
                $this->username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                $this->loginstring = hash("sha512", $dbPassword . $_SERVER["HTTP_USER_AGENT"]);
                $this->email = $email;
                if(!is_null($this->location)) $this->location = htmlspecialchars($this->location);
            }
            else throw new Exception("Invalid email or password, please try again.");
        }
    }

    public function getUserName()
    {
        return $this->username;
    }
    public function setUserName($username)
    {
        $this->username = htmlspecialchars($username);
    }

    public function getLoginString()
    {
        return $this->loginstring;
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
        if (preg_match("/-?[0-9]{2}.[0-9]{7},-?[0-9]{2}.[0-9]{7}/i", $newLoc)) $this->location = $newLoc;
    }

    public function checkAllergy($flag)
    {
        return $this->flags & $flag;
    }

    public function setAllergy($flag)
    {
        $this->flags = $this->flags & ~ $flag;
    }
}
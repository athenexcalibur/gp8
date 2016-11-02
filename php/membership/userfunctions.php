<?php
require_once (__DIR__ ."/../database.php");

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

function login($email, $password) 
{
    $dbconnection = Database::getConnection();
    if ($stmt = $dbconnection->prepare("SELECT id, username, password 
        FROM UsersTable
       WHERE email = ?
        LIMIT 1")) 
    {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userID, $username, $dbPassword);
        $stmt->fetch();

        if ($stmt->num_rows == 1 && password_verify($password, $dbPassword)) 
        {
            $userBrowser = $_SERVER["HTTP_USER_AGENT"];
            $userID = preg_replace("/[^0-9]+/", "", $userID);
            $_SESSION["userid"] = $userID;
            $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
            $_SESSION["username"] = $username;
            $_SESSION["loginString"] = hash("sha512", $dbPassword . $userBrowser);

            return true;
        }
    }
    return false;
}

function loginCheck() 
{
    $dbconnection = Database::getConnection();
    if (isset($_SESSION["userid"], $_SESSION["username"], $_SESSION["loginString"]))
    {
        $userid = $_SESSION["userid"];
        $loginString = $_SESSION["loginString"];
 
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
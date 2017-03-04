<?php
define("DBSERVER", "mysql.dur.ac.uk");
define("DBUSERNAME", "dcs8s08");
define("DBPASSWORD", "swansea2");

/*define("DBSERVER", "localhost");
define("DBUSERNAME", "root");
define("DBPASSWORD", "root");*/


class Database
{
    private static $db;
    private $dbconnection;

    private function __construct()
    {
        $this->dbconnection = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD);
        if ($this->dbconnection->connect_error) die("Couldn't connect to database: " . $this->dbconnection->connect_error);

        if (!$this->dbconnection->select_db("Pdcs8s08_CupboardDB")) $this->createDB();
    }

    function __destruct()
    {
        $this->dbconnection->close();
    }

    public static function getConnection()
    {
        if (self::$db == null)  self::$db = new Database();
        return self::$db->dbconnection;
    }

    public function createDB()
    {
        $createDBConnection = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD);
        if ($createDBConnection->connect_error) die("Couldn't connect to database: " . $createDBConnection->connect_error);

        if ($createDBConnection->query("CREATE DATABASE IF NOT EXISTS Pdcs8s08_CupboardDB"))
        {
            echo "Database created successfully";
        }
        else die("Error creating database: " . $createDBConnection->error);

        $createDBConnection->select_db("Pdcs8s08_CupboardDB");

        $query ="
        CREATE TABLE IF NOT EXISTS UsersTable
        (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(16) UNIQUE NOT NULL,
            email VARCHAR(64) UNIQUE NOT NULL,
            password VARCHAR(256) NOT NULL,
            flags TINYINT default 0,
            location VARCHAR(52),
            rating FLOAT default 3,
            score INT default 0,
			number INT default 0
         )";
        if (!$createDBConnection->query($query)) die("Failed to create user table");

        $query =
        "CREATE TABLE IF NOT EXISTS PostsTable
        (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(32)  NOT NULL,
            description VARCHAR(256),
            location VARCHAR(52),
            flags TINYINT default 0,
            userid INT NOT NULL,
            posttime DATETIME DEFAULT NOW(),
            expiry DATE
        )";
        if (!$createDBConnection->query($query)) die("Failed to create posts table");
		
		$query =
        "CREATE TABLE IF NOT EXISTS FinishedPostsTable
        (
            id INT UNSIGNED PRIMARY KEY,
            title VARCHAR(32)  NOT NULL,
            posterID INT NOT NULL,
			recepientID INT NOT NULL,
			recipientDone BOOL DEFAULT 0,
            fintime DATETIME DEFAULT NOW(),
            expiry DATE
        )";
        if (!$createDBConnection->query($query)) die("Failed to create finished posts table");

        $query ="
        CREATE TABLE IF NOT EXISTS MessagesTable
        (
          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          fromid INT NOT NULL,
          toid INT NOT NULL,
          text VARCHAR(256) NOT NULL,
          messagetime DATETIME DEFAULT NOW()
        )";
        if (!$createDBConnection->query($query)) die("Failed to create messages table");

        $this->dbconnection = $createDBConnection;
    }
}

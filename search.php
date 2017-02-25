<html>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <h3> Search food near you </h3><br>
  <p>
  <p>

    Title: <input type="text" name="title"><br><br>
    Location: <input type="text" name="title"><br><br>
    Flags (Check all that apply):
    <br><br>

    <input type="checkbox" name="flag" value="Halal">Halal<br>
    <input type="checkbox" name="flag" value="Kosher">Kosher<br>
    <input type="checkbox" name="flag" value="Vegan">Vegan<br>
    <input type="checkbox" name="flag" value="Vegetarian">Vegetarian<br>
    <input type="checkbox" name="flag" value="Peanut">Peanut<br>
    <input type="checkbox" name="flag" value="Gluten">Gluten<br>
    <input type="checkbox" name="flag" value="Lactose">Lactose<br>
    <input type="checkbox" name="flag" value="Soy">Soy<br><br>

    Description: <textarea name="description"></textarea><br><br>


    <input type="submit">

</body>

<?php
require_once(__DIR__. "php/database.php"); //Copies all data stored in the database
$POST = array();
parse_str(file_get_contents('php.input'),$_POST); //parses string into variables

$errorMessage = "";
$dbconnection = Database::getConnection();

//filters for search : title, location, flags, description

if (isset($_POST["title"], $_POST["location"], $_POST["flags"], $_POST["description"])) {
  $title = $_POST["title"];
  $location = $_POST["location"];
  $flags = $_POST["flags"];
  $description = $_POST["description"];

  $title = mysqli_real_escape_string($dbconnection, $title);
  $location = mysqli_real_escape_string($dbconnection, $location);
  $flags = mysqli_real_escape_string($dbconnection, $flags);
  $description = mysqli_real_escape_string($dbconnection, $description);

  $sql = "SELECT title,description,location,flags,posttime,expiry FROM PostsTable WHERE title LIKE '%" . $title . "%' OR location LIKE '%" . $location . "%' OR flags LIKE '%" . $flags . "%'OR description LIKE '%" . $description . "%'";

  $result = mysqli_query($sql);

  while ($row = mysqli_fetch_array($result)) {
    $title = $row["title"];
    $location = $row["location"];
    $flags = $row["flags"];
    $description = $row["description"];

    //display the result of array
    echo "<ul>\n";
    echo "<li>" . "<a  href=\"search.php?title=$title\">"   .$description . " " . $location . " " . $flags . " " . $posttime . " " . $expiry ."</a></li>\n";
    echo "</ul>\n";
  }
}
?>

</html>
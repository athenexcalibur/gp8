<?php
require_once "php/user.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit;
}?>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
    Email: <input type="text" id="email" name="email" value = <?php echo htmlspecialchars($_SESSION["user"]->getEmail());?>) <br/>
    Username: <input type="text" id="username" name="username" value = <?php echo htmlspecialchars($_SESSION["user"]->getUserName());?>) <br/>
</form>

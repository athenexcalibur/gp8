<?php
require_once "php/user.php";
if (!loginCheck())
{
    header("Location: ./index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>
</head>

<body>
Username: <input type="text" name="usersearch" id="usersearch" required/><br/>
Message:<br/>
<textarea name="message" min="5" max="256" id="messageBox"></textarea><br/>
<button id="sendMessage">Send</button>
</body>
</html>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/messages.js"></script>
<script type="text/javascript">
$(function()
{
    $("#usersearch").autocomplete
    ({
        source: "php/userAutocomplete.php",
        minLength: 1
    });

});
</script>
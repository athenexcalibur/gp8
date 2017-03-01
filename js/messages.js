function getMessages()
{
    console.log("here");
    $.get( "php/messages.php", function( data )
    {
        console.log(data);
    });
}

function getMessagesFrom(fromid)
{
    $.get( "php/messages.php", {otherid: fromid}, function( data )
    {
        console.log(data);
    });
}

getMessages();
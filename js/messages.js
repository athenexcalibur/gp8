"use strict";

function getMessages()
{
    $.get( "php/messages.php", function( data )
    {
        console.log(data);
        for (var i = 0; i < data.length; i++)
        {
            var fromname = data.fromname;
            var text = data.text;
            var datetime = new Date(data.time);
        }
    });
}

function getMessagesFrom(fromname)
{
    console.log("here");
    $.get( "php/messages.php?othername=" + fromname, function( data )
    {
        console.log(data);
    });
}

$("#sendMessage").on("click", function()
{
    $.post("php/messages.php",
    {
        toUser: $("#usersearch").val(),
        message: $("#messageBox").val()
    }, function(data)
    {
        console.log(data); //todo delete this
        $("#messageBox").clear();
    });
});
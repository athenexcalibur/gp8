$("#sendMsg").on("click", function()
{
    $.post("php/messages.php",
    {
        toUser: window.otheruser,
        message: $("#message").val()
    }, function(data)
    {
        console.log(data); //todo delete this
        $("#message").val("");
        fillMessages();
    });
});

function fillMessages()
{
    var otheruser = window.otheruser = window.location.search.substr(12);
    var url = "php/messages.php?othername=" + otheruser;
    $.get(url, function(data)
    {
        var messages = data;
        var allBoxes = "";
        for (var i = 0; i < messages.length; i++)
        {
            var message = messages[i];
            allBoxes += '<div class="message';
            if(message["toname"] == otheruser)
            {
                allBoxes+= 'Sent';
            }
            else
            {
                allBoxes+= 'Recieved';
            }

            allBoxes += ' card card-block">'
                + '<p>'
                + message["text"]
                + '</p></div>'
                + '<p class="time">' + message.time + '</p>'
        }
        document.getElementById("messages").innerHTML = allBoxes;
    });

}

function testMessages()
{
    var otheruser = document.getElementById("threadname").innerHTML;

    var messages = [{text : "hi foodiedave", toname : otheruser},{text : "its me foodiedave"}];
    var allBoxes = "";
    for (var i = 0; i < messages.length; i++)
    {
        var message = messages[i];
        allBoxes += '<div class="message';
        if(message["toname"] == otheruser)
        {
            allBoxes+= 'Sent';
        }
        else
        {
            allBoxes+= 'Recieved';
        }

        allBoxes += ' card card-block">'
            + '<p>'
            + message["text"]
            + '</p></div>'
    }
    document.getElementById("messages").innerHTML = allBoxes;
}
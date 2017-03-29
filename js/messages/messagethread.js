$(document).ready(function ()
{
    fillMessages();
    fillDropdown();
    threadName = findGetParameter("threadname");
    $("#threadname").html(threadName);

    //line up threadinfo card with navbar)
    h = $("nav.navbar-fixed-top").css("height");
    $("main").css("padding-top", h);
    //line up final message with message input div 
    h = $("nav.navbar-fixed-bottom").css("height");
    $("main").css("padding-bottom", h);
    //scroll down to last message
    $(".snap-content").animate({scrollTop: $(".snap-content").height() * 2}, 1000);
});

$("#sendMsg").on("click", function ()
{
    $.post("php/messages.php",
    {
        toUser: window.otheruser,
        message: $("#message").val()
    }, function (data)
    {
        console.log(data); //todo delete this
        $("#message").val("");
        //TODO Probably meed to find a better solution than reloading the
        //entire message div
        fillMessages();
        $(".snap-content").animate({scrollTop: $(".snap-content").height() * 2}, 1000);
    });
});

function fillMessages()
{
    var otheruser = window.otheruser = window.location.search.substr(12);
    var url = "php/messages.php?othername=" + otheruser;
    $("#messageDiv").empty();
    $.get(url, function (data)
    {
        var messages = data;
        if (messages.length == 0)
        {
            $("#messageDiv").append('<p class="text-muted text-fluid mx-auto" style="text-align: center">no messages</p>');
            return;
        }

        var inPrototype = $(".in-prototype");
        var outPrototype = $(".out-prototype");
        console.log(inPrototype);
        console.log(outPrototype);
        for (var i = messages.length - 1; i >= 0; i--)
        {
            var message = messages[i];
            console.log(message);
            if (message.toname === otheruser)
            {
                content = inPrototype.clone();
                content.css("display", "block");
                content.find(".card-text.msg").html(message.text);
                content.find(".time-stamp").html(message.time);
                $("#messageDiv").append(content);
            }
            else
            {
                content = outPrototype.clone();
                content.css("display", "block");
                content.find(".card-text.msg").html(message.text);
                content.find(".time-stamp").html(message.time);
                $("#messageDiv").append(content);
            }
        }
    });
}

function fillDropdown()
{
    $.get("php/post/postTools.php", function(data)
    {
        var stillUp = JSON.parse(data).stillUp;
        console.log(stillUp);
        var HTML = "";
        for (var i = 0; i < stillUp.length; i++)
        {
            var current = stillUp[i];
            HTML += "<a class='dropdown-item' href='#' onclick='reserveItem(" + current.id + ")'>'" + current.title + "' (" + current.posttime + ")</a>"
        }
        $("#dDropdownContainer").html(HTML);
    })
}

function reserveItem(id)
{
    $.post("php/post/postTools.php", {postID: id, otherUser: window.otheruser});
}

function findGetParameter(parameterName)
{
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++)
    {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

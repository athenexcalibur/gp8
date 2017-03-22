$(document).ready(function () {
    fillMessages();
    threadName = findGetParameter("threadname");
    $("#threadname").html(threadName);
    //shift card up
    h = $("nav.navbar").css("height");
    console.log(h);
    $("main").css("padding-top", h);
});

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
	var inPrototype = $(".in-prototype");
	var outPrototype = $(".out-prototype");
	console.log(inPrototype);
	console.log(outPrototype);
        for (var i = messages.length - 1; i >= 0; i--)
        {
	    var message = messages[i];
	    if(message.toname === otheruser){
		content = inPrototype.clone();
		content.css("display", "block")
		content.find(".card-text").html(message.text);
		$("#messageDiv").append(content);
	    }
	    else {
		content = outPrototype.clone();
		content.css("display", "block")
		content.find(".card-text").html(message.text);
		$("#messageDiv").append(content);
	    }

        }
    });

}


function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

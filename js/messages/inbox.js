console.log("Hi");

$(document).ready(function () {
    $.get("php/messages.php", function (data) {
	console.log(data); 
	$.each(data, function (index, threadObj) {
	    date = new Date(threadObj.time*1000);
	    card = $(".thread-prototype").clone();
	    //set link
	    link = card.find("a").attr("href") + threadObj.fromname;
	    card.find("a").attr("href", link);
	    //set innerhtml text
	    card.find(".card-title").html(threadObj.fromname);
	    card.find(".message-text").html(threadObj.text);
	    card.find(".message-time").html(date.toLocaleString());
	    //make visible and append to cards div
	    card.removeClass("thread-prototype");
	    $("#threadCards").append(card)
	})
    });
});

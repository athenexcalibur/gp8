"use strict";

$(document).ready(function () {
    if (window.location.href.includes("mylistings.php"))
	fillListings();
    else if (window.location.href.includes("orders.php"))
	fillOrders();
	
});

function fillListings()
{
    var url = "php/post/postTools.php";
    $.get(url, function (data)
	    {
		var history = JSON.parse(data);
		var stillUp = history["stillUp"];
		addCards(stillUp,
			"currentlistings",
			newListingCard,
			"You have no current listings!");

		var bothDone = history["bothDone"];
		addCards(bothDone,
			"pastlistings",
			newPastListingCard,
			"You've not yet recieved any items. You can change this using the search page.");
	    });
}

function fillOrders()
{
    var url = "php/post/postTools.php";
    //$("#current").html("");
    //$("#history").html("");
    $.get(url, function (data)
	    {
		var history = JSON.parse(data);
		console.log(history);

		//fill current
		$.each(history.orders, function (index, value) {
		    var card = $(".current-prototype").clone();
		    card.removeClass("current-prototype");
		    card.find(".card-title").html(value.title);
		    card.find(".btn").attr("data-orderid", value.id);
		    $("#current").append(card);
		});

		var fin = history.bothDone.concat(history.waitingForYou);
		//fill history
		$.each(fin, function (index, value) {
		    var card = $(".history-prototype").clone();
		    card.removeClass("history-prototype");
		    card.find(".card-title").html(value.title);
		    card.find(".completion-time").html(value.fintime);
		    $("#history").append(card);
		});
	    });
}

function addCards(infoArray, elementID, cardGenerator, exceptionMessage) {
    if (infoArray.length === 0) document.getElementById(elementID).innerHTML = exceptionMessage;
    else
    {
	var html = "";
	for (var i = 0; i < infoArray.length; i++)
	{
	    var order = infoArray[i];
	    html += cardGenerator(order);
	}
	document.getElementById(elementID).innerHTML = html;
    }
}

function submitrating(postID)
{
    var rating = $("input[name=rating]:checked").val();
    $.post("php/post/postTools.php", {postID: postID, rating: rating}, function(data)
    {
        console.log(data);
    });
    fillOrders();
}

function sendCancelMessage(orderID)
{
    var message = document.getElementById("cancelmessagetext").value;
    console.log(message);
}

function newPastListingCard(order)
{
    var html = ' <div class="row">'
        + '<div class="col-xs-3">'
        + '      <div class="card-block">'
        + '       <div class="view overlay hm-white-slight z-depth-1">'
        + '          <img src="img/vege-card.jpg" class="img-responsive" alt="">'
        + '        <a href="#">'
        + '          <div class="mask waves-effect"></div>'
        + '        </a>'
        + '     </div>'
        + '      </div>'
        + '	</div>'

        + '     <div class="col-xs-9">'
        + '  <div class="card-block">'
        + '  <div class="row">'
        + '	<div class="col-xs-6">'
        + '    <h3 id="foodname" class="card-title">' + order["title"] + '</h3>'
        + '	</div>'
        + '	<div class="col-xs-6">'
        + '		<div class="col-xs-2">'
        + '			<img src = "./avatar/test.png" />'
        + '		</div>'
        + '		<div class="col-xs-4">'
        + '			<p class="seller">' + order["posterID"] + '</p>'
        + '		</div>'
        + '	</div>'
        + '	</div>'
        + '   <h6 class="text-muted">' + order["fintime"] + '</h6>'
        //+'	<p class="rating">' + order["rating"] + ' stars</p>'
        + '  </div>'
        + ' </div>'
        + '  </div>';

    return html;
}

function newListingCard(order)
{
    var orderID = order["id"];
    var html =
        ' <div class="card order-card">'
        + '  <div class="row">'
        + '   <div class="col-xs-3">'
        + '          <div class="card-block">'
        + '           <div class="view overlay hm-white-slight z-depth-1">'
        + '             <img src="img/vege-card.jpg"'
        + '                 class="img-responsive"'
        + '                alt="">'
        + '        <a href=listing.php?id=' + order.id +'>'
        + '           <div class="mask waves-effect"></div>'
        + '       </a>'
        + '         </div>'
        + '          </div>'
        + '		</div>'
        + '       <div class="col-xs-9">'
        + '	  <div class="card-block">'
        + '	  <div class="row">'
        + '		<div class="col-xs-6">'
        + '	    <h3 class="foodname card-title">' + order["title"] + '</h3>'
        + '		</div>'
        + '		</div>'
        + '	  </div>'
        + '	</div>'
        + '      </div>'
        + '	</div>';

    return html;
}

$('#recievedModal').on('show.bs.modal', function (event)
{
    var button = $(event.relatedTarget); // Button that triggered the modal
    var orderID = button.data('orderid'); // Extract info from data-* attributes
    var modal = $(this);
    modal.find('#myModalLabel').text('Please rate item with id = ' + orderID);
    modal.find('.btn-primary').click(function() {
	submitrating(orderID)  
    });
});

$('#cancelmodal').on('show.bs.modal', function (event)
{
    var button = $(event.relatedTarget); // Button that triggered the modal
    var orderID = button.data('orderid'); // Extract info from data-* attributes
    var seller = "FoodieDave"; //todo make into the correct seller (use itemid)
    var itemname = "Beanz"; //todo make into the correct item name (use itemid)
    var modal = $(this);
    //debug
    modal.find("#myModalLabel").text("To " + seller);
    var cancelmessagetext = modal.find("#cancelmessagetext");
    var prevtext = cancelmessagetext.attr('value');
    cancelmessagetext.val(prevtext + itemname);
    console.log("cancelmodal showing");
    modal.find('#modal_sendcancelmessage').click(function () {
	sendCancelMessage(orderID);
    });
});

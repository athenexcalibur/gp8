"use strict";

$(document).ready(fillOrders());

function fillOrders()
{
    var url = "php/post/postTools.php";
    $.get(url, function (data)
    {
        var history = JSON.parse(data);
        var stillUp = history["waitingForYou"];

        if (stillUp.length === 0) document.getElementById("currentorders").innerHTML = "No orders are waiting for you!";
        else
        {
            var html = "";
            for (var i = 0; i < stillUp.length; i++)
            {
                var order = stillUp[i];
                html += newOrderCard(order);
            }
            document.getElementById("currentorders").innerHTML = html;
        }

        var html = "";
        var bothDone = history["bothDone"];
        if (bothDone.length === 0) document.getElementById("pastorders").innerHTML = "You've not yet recieved any items. You can change this using the search page.";
        else
        {
            for (var i = 0; i < bothDone.length; i++)
            {
                var order = bothDone[i];
                html += newPastOrderCard(order);
            }
            document.getElementById("pastorders").innerHTML = html;
        }
    });
}

function submitrating(postID)
{
    var rating = $("input[name=rating]:checked").val();
    console.log(rating);
    var url = "php/finalisePost.php?postID=" + postID + "&rating=" + rating;
    $.post(url);
    fillOrders();
}

function sendCancelMessage(orderID)
{
    var message = document.getElementById("cancelmessagetext").value;
    console.log(message);
}

function newPastOrderCard(order)
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

function newOrderCard(order)
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
        + '          <a href="#">'
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
        + '		<div class="col-xs-6">'
        + '			<div class="col-xs-2">'
        + '			<img src = "./avatar/test.png" />'
        + '			</div>'
        + '			<div class="col-xs-4">'
        + '				<p class="seller">' + order["userid"] + '</p>'
        + '			</div>'
        + '		</div>'
        + '		</div>'
        + '	    <div class="details-link">'
        + '	      <a class="card-link" href="inbox.html" onclick="viewCoversation(' + orderID + '")>View conversation</a>'
        + '	    </div>'
        + '	  </div>'
        + '	</div>'

        + '      </div>'

        + '	  <div class = "buttons">'
        + '		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#recievedModal" data-orderid ="' + orderID + '">RECIEVED</button>'
        + '		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelmodal" data-orderid ="' + orderID + '">CANCEL</button>'
        + '	  </div>'
        + '	</div>';

    return html;
}

$('#recievedModal').on('show.bs.modal', function (event)
{
    var button = $(event.relatedTarget); // Button that triggered the modal
    var orderID = button.data('orderid'); // Extract info from data-* attributes
    var modal = $(this);
    //debug
    modal.find('#myModalLabel').text('Please rate item with id = ' + orderID);
    modal.find('#modal_submitrating').click(submitrating(orderID));
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
    modal.find('#modal_sendcancelmessage').click(sendCancelMessage(orderID));
});
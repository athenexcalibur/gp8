"use strict";

$(document).ready(function () {
  /*
  *if (window.location.href.includes("mylistings.php"))
  *    fillListings();
  *else if (window.location.href.includes("orders.php"))
  *    fillOrders();
  */

  $('.nav-pills').on('shown.bs.tab', 'a', function(e) {
    if (e.relatedTarget) {
      $(e.relatedTarget).removeClass('active');
    }
  });
  fillTabs();
});

function fillTabs() {
  var url = "php/post/postTools.php";
  $(".tab-pane").html("");
  $.get(url, function (data) {
    var history = JSON.parse(data);
    console.log(history);
    $.each(history, function (key, array) {
      $.each(array, function (index, obj) {
        //Current Orders: orders && waitingForYou(recipientID = uid)
        //OrderHistory: bothDone(recipientID = uid) waitingForThem(recipientID = uid)
        //Current Listings - Still Up: stillUp()
        //Current Listings - Reserved: reserved && waitingForYou(posterID = uid)
        //Listing History - bothDone(posterID = uid) && waitingForThem(posterID = uid)
        $.get("php/userID.php", function (data) {
          var userID = data;
          console.log(userID);
          switch (key) {
            case 'orders':
            addCard("#orders_current", "current", obj);
            break;
            case 'stillUp':
            addCard("#listings_stillUp", "still-up", obj);
            break;
            case 'reserved':
            addCard("#listings_reserved", "current", obj);
            break;
            case 'waitingForYou':
            if (userID === obj.recipientID)
            addCard("#orders_current", "current", obj);
            else
            addCard("#listings_reserved", "current", obj);
            break;
            case 'waitingForThem':
            if (userID === obj.recipientID)
            addCard("#orders_history", "history", obj);
            else
            addCard("#listings_history", "history", obj);
            break;
            default: //BothDone
            if (userID === obj.recipientID)
            addCard("#orders_history", "history", obj);
            else
            addCard("#listings_history", "history", obj);
          }
        });
      });
    });
  });
}

function addCard(tabID, protoype, obj){
  var currentProto = $(".current-prototype").clone();
  currentProto.removeClass("current-prototype");
  var historyProto = $(".history-prototype").clone();
  historyProto.removeClass("history-prototype");
  var card;
  if (protoype == "current") {
    card = currentProto.clone();
    card.find(".card-title").html(obj.title);
    card.find(".btn").attr("data-orderid", obj.id);
    //console.log(card.html());
  } else if (protoype == "history") {
    card = historyProto.clone();
    card.removeClass("history-protoype");
    card.find(".card-title").html(obj.title);
    card.find(".timestamp").html(obj.fintime); //add timestamp
  } else if (protoype == "still-up") {
    card = historyProto.clone();
    card.removeClass("history-protoype");
    card.find(".card-title").html(obj.title);
    card.find(".timestamp").html(obj.posttime); //add timestamp
    card.find("a").attr("href", "listing.php?id=" + obj.id)
  }

  $(tabID).append(card);

  $.getScript("js/itemimage.js", function()
  {
    card.find(".itemimage").attr("data-itemid", obj.id);
    console.log(card.find(".itemimage").attr("data-itemid"));

    fixImg(card);
  });
}

function submitrating(postID)
{
  var rating = $("input[name=rating]:checked").val();
  $.post("php/post/postTools.php", {postID: postID, rating: rating}, function(data)
  {
    console.log(data);
  });
  fillTabs();
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

$("#cancelBtn").on("click", function()
{
  $.post("php/post/postTools.php", {postID: $(this).data(id), cancel: true}, function(data){console.log(data);});
  fillTabs();
});
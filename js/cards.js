$(document).ready(function() {
	$.get("ajax/card.html", function(data) {
		$(".item-card").html(data);
	});
	$.get("ajax/orderCard.html", function(data) {
		$(".order-card").html(data);
	});
});


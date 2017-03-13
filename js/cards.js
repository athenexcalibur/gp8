$(document).ready(function() {
	$.get("ajax/card.html", function(data) {
		$(".item-card").html(data);
	});
	
	$.get("ajax/orderCardPast.html", function(data) {
		$(".past-order-card").html(data);
	});
});


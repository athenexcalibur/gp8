$(document).ready(function() {
	$.get("ajax/card.html", function(data) {
		$(".item-card").html(data);
	});
});


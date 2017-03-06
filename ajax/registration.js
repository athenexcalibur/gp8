var submission = {};
submission.name = "Name";
console.log(submission);


$(document).ready(function() {
    $("#registrationBtn").click(function(){
	$.get("ajax/userDetails.html", function(data) {
	    $("#registrationModal .modal-body").html(data)
	});
    });
    $("#nextBtn").click(function(){
	$.get("ajax/userAddress.html", function(data) {
	    $("#registrationModal .modal-body").html(data)
	});
	$(this).click(function(){
	    $.get("ajax/userAllergens.html", function(data) {
		$("#registrationModal .modal-body").html(data);
		console.log(data)
	    });
	    this.id = "nextBtn";
	});
    });
});

var submission = {};
submission.name = "Name";
console.log(submission);


$(document).ready(function() {
    /*$("#registrationBtn").click(function(){
	$.get("ajax/userDetails.html", function(data) {
	    $("#registrationModal .modal-body").html(data)
	});
    });*/
	
	$("#registerBtn").click(function()
	{
		console.log("here!");
		$.ajax({
		type: "POST",
		url: "php/membership/register.php", //TODO password verification
		data:{
			username: $("#username").val(),
			email: $("#email").val(),
			password: $("#password").val()},
			success: function(data){console.log("good")},
		  error: function(xhr, textStatus, error){
			  console.log(xhr.statusText);
			  console.log(textStatus);
			  console.log(error);
		}});
	});
	
	$("#loginBtn").click(function()
	{
		$.post("php/membership/login.php",
		{email: $("#uemail").val(),
		password: $("#upass").val()},
		function(data)
		{
			console.log(data);
		});
	});
	
	/*
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
    });*/
});

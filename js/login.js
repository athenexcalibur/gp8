$("#registerBtn").on("click", function()
{
    $.post("php/membership/register.php",
	{
        email: $("#email").val(),
        username: $("#username").val(),
        password: $("#password").val()
    }, function(data)
    {
        console.log(data);
		//location.reload(true);
    }).fail(function(response)
    {
        alert('Error: ' + response.responseText);
    });
    //todo switch to login modal
});

$("#nextBtn").click(function(){
    if ($("#regDiv1").css("display") !== "none")
	{
        $("#regDiv1").fadeOut(function()
		{
			$("#regModalLabel").html("Location");
			$("#regDiv2").fadeIn(initMap());
		});
	}
	else
	{
		$("#regDiv2").fadeOut(function()
		{
			$("#regModalLabel").html("Allergens");
			$("#nextBtn").hide();
			$("#regDiv3").fadeIn();
		});
	}
});

$("#regCancel").on("click", function()
{
	$(".regDivs").hide();
	$("#regModalLabel").html("User Details");
	$("#regDiv1").show();
	$("#nextBtn").show();
	//todo fix map falling over when cancelling and restarting
});

$("#loginBtn").on("click", function()
{
    $.post("php/membership/login.php",
    {
        email: $("#uemail").val(),
        password: $("#upass").val()
    }, function()
    {
        location.reload(true);
    }).fail(function(response)
    {
        alert('Error: ' + response.responseText);
    });

});


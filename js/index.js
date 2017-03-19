

//login stuff ----
$("#registerBtn").on("click", function()
{
    $.post("php/membership/register.php",
	{
        email: $("#email").val(),
        username: $("#username").val(),
        password: $("#password").val(),
        location: window.currentlatLng.lat() + ',' + window.currentlatLng.lng(),
        flags: createFlags()
    }, function(data)
    {
        console.log(data);
		location.reload(true);
    }).fail(function(response)
    {
        alert('Error: ' + response.responseText);
    });
    //todo switch to login modal
});

function createFlags()
{
    var selected = [];
    $("#diatary").find(":selected").each(function()
    {
        selected.push($(this).val());
    });

    $("#allergens").find(":selected").each(function()
    {
        selected.push($(this).val());
    });

    return selected;
}

$("#nextBtn").click(function()
{
    if ($("#regDiv1").css("display") !== "none")
	{
        $("#regDiv1").fadeOut(function()
		{
			$("#regModalLabel").html("Location");
            $("#nextBtn").prop("disabled", true);
            $("#regDiv2").fadeIn();
            reInitMap();
		});
	}
	else
	{
		$("#regDiv2").fadeOut(function()
		{
			$("#regModalLabel").html("Allergens");
            $("#registerBtn").show();
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
    $("#nextBtn").prop("disabled", false);
    $("#registerBtn").hide();
    reInitMap();
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

/* validation
$(document).ready(function ()
{
    //disable submission button untill passwords match and email matches regex
    $("#registerbutton").prop("disabled", true);
    $("#regstrationModal").on("input", function()
    {
        var pass1 = $("#password").val();
        var pass2 = $("#checkpass").val();
        var email = $("#email").val();

        if (pass1 && pass1.length >= 6 && pass1 === pass2)// && email.match(emailRE))
        {
            $("#registerBtn").prop("disabled", false);
        }
        else
        {
            $("#registerBtn").prop("disabled", true);
        }
    });
});
*/

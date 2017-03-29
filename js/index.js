

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
        window.currentlatLng = undefined;

        $("#registrationModal").modal("hide");
        $("#loginModal").modal("show");
        resetReg();
    }).fail(function(response)
    {
        alert('Error: ' + response.responseText);
    });
});

function createFlags()
{
    var selected = [];
    $("#dietary").find(":selected").each(function()
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

function resetReg()
{
    $(".regDivs").hide();
    $("#regModalLabel").html("User Details");
    $("#regDiv1").show();
    $("#nextBtn").show();
    $("#nextBtn").prop("disabled", false);
    $("#registerBtn").hide();
    reInitMap();
}

$("#regCancel").on("click", resetReg);

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

//Make form submittable with enter key
//NOTE: couldn't get it to work with regDiv3 (i.e. dietary requirements)
//because the select tag switches the focus
//could add submittable class to the select tags but it seems a little messy
$(".submittable").keyup(function (event) {
    if (event.keyCode == 13) {
        triggerBtn = $(this).attr("trigger-btn");
	$(triggerBtn).trigger("click");
    }
});

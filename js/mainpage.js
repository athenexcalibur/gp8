$(document).ready(function () {

    //disable submission button untill passwords match and email matches regex
    $("#registerbutton").prop("disabled", true);
    $("#regform").on("input", function()
    {
        var pass1 = $("#rpassword").val();
        var pass2 = $("#rcheckpass").val();
        var email = $("#remail").val();

        if (pass1 && pass1.length >= 6 && pass1 === pass2)// && email.match(emailRE))
        {
            $("#registerbutton").prop("disabled", false);
        }
        else
        {
            $("#registerbutton").prop("disabled", true);
        }
    });
});
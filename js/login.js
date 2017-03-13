$("#registerBtn").on("click", function()
{
    console.log("here");
    //if ($("#password").val() !== $("#passwordConfirm").val()) return; TODO uncomment me
    $.post("php/membership/register.php",
    {
        email: $("#email").val(),
        username: $("#username").val(),
        password: $("#password").val()
    }, function(data)
    {
        console.log(data);
    }).fail(function(response)
    {
        alert('Error: ' + response.responseText);
    });
    //todo switch to login modal
});

$("#nextBtn").click(function(){
    $.get("ajax/userAddress.html", function(data) {
        $("#registrationModal .modal-body").html(data);
        initMap();
        google.maps.event.trigger(map, "resize");
    });
    $(this).click(function(){
        $.get("ajax/userAllergens.html", function(data) {
            $("#registrationModal .modal-body").html(data);
            console.log(data)
        });
        this.id = "nextBtn";
    });
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


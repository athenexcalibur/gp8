//todo hook up listing page
function createCard(post)
{
    var otheruser = $.get("php/user.php", {id: post.userid});
    return '\
        <div class="card order-card">\
        <div class="row">\
        <div class="col-xs-3">\
        <div class="card-block">\
        <div class="view overlay hm-white-slight z-depth-1">\
        <img src="img/vege-card.jpg" class="img-responsive" alt="">\
        <a href="listing.php?id=' + post.id + '>\
        <div class="mask waves-effect"></div>\
        </a></div></div></div>\
        <div class="col-xs-9">\
        <div class="card-block">\
        <div class="row">\
        <div class="col-xs-6">\
        <h3 class="foodname card-title">' + post.title + '</h3>\
        </div><div class="col-xs-6"><div class="col-xs-2">\
        <img src = "./avatar/test.png" />\
        </div><div class="col-xs-4">\
        <p class="seller">' + otheruser + '</p>\
        </div></div></div>\
        <div class="details-link">\
        <a class="card-link" href="messagethead.php?threadname=' + otheruser + '">View conversation</a>\
        </div></div></div></div>\
        <div class = "buttons">\
        <button type="button" class="btn btn-success" onclick="submitrating(' + post.id + ')">RECIEVED</button>\
        <button type="button" class="btn btn-danger">CANCEL</button></div></div>';
}


function fillOrders()
{
    $.get("php/postTools.php", function (data)
    {
        var ret = JSON.parse(data);
        console.log(ret);
        var currentOrders = ret.stillUp;

        for (var i = 0; i < currentOrders.length; i++)
        {

            var card = $(document.createElement('div'));
            card.html(createCard(currentOrders[i]));
            card.attr('data-id', currentOrders[i].id);
            $(".order-cards").append(card);
        }
    });
}

function submitrating(postID)
{
    var rating = $("input[name=rating]:checked").val();
    console.log(rating);
    var url = "php/finalisePost.php?postID=" + postID + "&rating=" + rating;
    $.post(url);
    fillOrders();
}
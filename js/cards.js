$(document).ready(function ()
{
    $.get("php/search.php", function (data)
    {
        var posts = JSON.parse(data);
        posts.sort(function(a,b){return a.distance - b.distance});
        $.get("ajax/card.html", function (data)
        {
            tmp = $("<out>").append(data);
            $(".item-card").each(function (i, obj)
            {
                if (i < posts.length)
                {
                    name = posts[i]["title"];
                    name = name ? posts[i]["title"] : "Untitled";
                    tmp.find("#title").html(name);
                    tmp.find("#distance").html(posts[i]["distance"].toFixed(1) + " miles away");
                }
                else
                {
                    tmp.find("#title").html("EOF");
                }
                $(obj).html(tmp.clone());
                $(obj).attr("id", i.toString());
            });
        });
    });
});

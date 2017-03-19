$(document).ready(function ()
{
    $.get("php/search.php", function (data)
    {
        //posts = JSON.parse(data) not needed on my comptuter, maybe on uni computers
        var posts = data;
        console.log(posts);
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


$(document).ready(function ()
{
    $.get("php/search.php", function (data)
    {
        var posts = JSON.parse(data);
	console.log(data);
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

                    var distance = posts[i].distance? posts[i].distance.toFixed(1) + " miles away" : " ";
                    tmp.find("#distance").html(distance);
                    //todo decription and time
                }
                else
                {
                    tmp.find("#title").html("EOF");
		    tmp.find("#distance").html("");
                }
                $(obj).html(tmp.clone());
                $(obj).attr("id", i.toString());
            });
        });
    });
});

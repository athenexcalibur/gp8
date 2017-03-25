"use strict";

$(document).ready(function() {
    $("#showFilters").click(function(){
	$(".search-options-container").toggle();
    });
});

function parseDate(string)
{
    //2017-03-25 06:05:12
    var arr = string.split(" ");
    var ymd = arr[0].split("-");
    var hms = arr[1].split(":");
    return new Date(ymd[0], ymd[1]-1, ymd[2], hms[0], hms[1]);
}

function getResultHTML(post)
{
    var HTML = '<div class="card hoverable">' +
                '<h5 id="title" class="card-title">' + post.title + '</h5>' +
                '<div class="card-image">' +
                '<div class="view overlay hm-white-slight z-depth-1">' +
                '<img src="img/vege-card.jpg" class="img-responsive" alt="">' +
                '<a id="link" href="listing.php?id=' + post.id + '">' +
                '<div class="mask waves-effect"></div>' +
                '</a></div></div>' +
                '<div id="distance" class="card-block text-xs-center">' +
                (post.distance? post.distance.toFixed(1) + " miles away" : "") +
                '</div></div>';
                //todo expand this to add other info (decription, poster name/score/rating, time, expiry)

    return HTML;
}

function sortByDistance(a,b){return a.distance - b.distance;}
function sortByScore(a,b){return a.posterscore - b.posterscore;}
function sortByRating(a,b){return a.posterrating - b.posterrating;}
function sortByExpiry(a,b){return a.posterrating - b.posterrating; /*todo - dates don't work*/}
function sortByMostRecent(a,b){return a.posttime <= b.posttime;}


function populateSearchResults()
{
    var checked = [];
    $(".allergyBoxes").find("input:checked").each(function()
    {
        checked.push($(this).attr("value"));
    });

    $.get("php/search.php",
    {
        keywords: $("#searchBox").val(),
        flags: checked
    }, function (data)
    {
        var posts = JSON.parse(data);
        var resContainer = $("#results");
        if (posts.length > 0)
        {
            resContainer.html("");
            posts.sort(populateSearchResults.sFun);
            for (var i = 0; i < posts.length; i++)
            {
                posts[i].posttime = parseDate(posts[i].posttime);
                resContainer.append(getResultHTML(posts[i]));
            }
        }
        else resContainer.html("No results found.");
    });
}

$(document).ready(function()
{
    populateSearchResults.sFun = sortByDistance;
    var sortBy = $("#sortBy");
    sortBy.find("a").click(function()
    {
        $("#selected").text($(this).text());

        switch ($(this).text())
        {
            case "Distance":
                populateSearchResults.sFun = sortByDistance;
                break;

            case "Soonest Expiry":
                populateSearchResults.sFun = sortByExpiry;
                break;

            case "Most Recent":
                populateSearchResults.sFun = sortByMostRecent;
                break;

            case "User Score":
                populateSearchResults.sFun = sortByScore;
                break;

            case "User Rating":
                populateSearchResults.sFun = sortByRating;
                break;
        }
        populateSearchResults();
    });

    sortBy.on("input", populateSearchResults);
    populateSearchResults();
});

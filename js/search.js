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
function sortByExpiry(a,b){return a.expiry <= b.expiry;}
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
        window.posts = posts;
        var resContainer = $("#results");
        if (posts.length > 0)
        {
            resContainer.html("");
            posts.sort(populateSearchResults.sFun);
            for (var i = 0; i < posts.length; i++)
            {
                posts[i].posttime = parseDate(posts[i].posttime);
                posts[i].expiry = parseDate(posts[i].expiry);
                resContainer.append(getResultHTML(posts[i]));
            }
        }
        else resContainer.html("No results found.");
    });
}

function strToLatLng(l)
{
    var latlng = l.replace(/[^0-9,.-]/g, "").split(",");
    return new google.maps.LatLng(parseFloat(latlng[0]), parseFloat(latlng[1]));
}

function createPopup(post)
{
    return "<h3>" +  post.title + "</h3><br/>" + post.description; //todo make this good
}

function initMap()
{
    var map = new google.maps.Map(document.getElementById("resultsMap"),
    {
        center: {lat: 53.303287539568494, lng: -1.478261947631836},
        zoom: 8,
        mapTypeId: 'roadmap'
    });

    window.map = map;

    for(var i = 0; i < window.posts.length; i++)
    {
        var m = new google.maps.Marker
        ({
            position: strToLatLng(window.posts[i].location),
            map: map
        });

        var infowindow = new google.maps.InfoWindow({content: createPopup(posts[i])});
        var purl = "listing.php?id=" + posts[i].id;
        google.maps.event.addListener(m, "click", function(){window.location.replace(purl)})
        google.maps.event.addListener(m, "mouseover", function(){infowindow.open(map, this);});
        google.maps.event.addListener(m, "mouseout", function(){infowindow.close()});
    }

    google.maps.event.trigger(map, "resize");
}



$("#mapShow").on("click",function()
{
    initMap();
});

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

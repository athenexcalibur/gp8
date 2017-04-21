"use strict";

$(document).ready(function() {
    $("#showFilters").click(function(){
	$(".search-options-container").slideToggle();
    });
    var searchText = findGetParameter("searchText");
    var callingPage = document.referrer;
    if(searchText != "null" && callingPage != "null"){
	if (callingPage.includes("index.php") && searchText) {
	    $("#searchBox").val(urldecode(searchText));
	    populateSearchResults();
	}
    }
    $("#searchBtn, #refineBtn").click(function() {
        populateSearchResults();
    });
});

function parseTime(string)
{
    var arr = string.split(" ");
    var ymd = arr[0].split("-");
    var hms = arr[1].split(":");
    return new Date(ymd[0], ymd[1]-1, ymd[2], hms[0], hms[1]);
}

function parseDate(string)
{
    var arr = string.split("-");
    return new Date(arr[0], arr[1]-1, arr[2]);
}

function getResultHTML(post)
{
    var HTML = '<div class="card card-hoverable">' +
		'<a href="listing.php?id=' + post.id + '"></a>' +
		'<div class="card-block order-img">' +
		'<img class = "itemimage" id="card_image" data-itemid=' + post.id + '/>' +
		'</div>' +
		'<div class="card-block">' +
		'<h4 class="card-title">' + post.title + '</h4>' +
		'<p class="card-text text-muted distance">' +
		(post.distance? post.distance.toFixed(1) + " miles away" : "") +
		'</p>' +
		'</div> </div>';
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
    $.ajax({url: "js/itemimage.js",
      dataType: "script",
      success: function()
        {
          var checked = [];
          $("input:checkbox[name=allergyCheck]:checked").each(function()
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
                      posts[i].posttime = parseTime(posts[i].posttime);
                      posts[i].expiry = parseDate(posts[i].expiry);
                      resContainer.append(getResultHTML(posts[i]));
		      imageSources[posts[i].id] = addSource(posts[i]);
                  }
              }
              else resContainer.html("No results found.");
              fixImgs();
              console.log(resContainer.html());
          });
        }
      });
}

function strToLatLng(l)
{
    var latlng = l.replace(/[^0-9,.-]/g, "").split(",");

    var la, lo;
    la = Math.random() * 0.1 - 0.05;
    lo = Math.random() * 0.1 - 0.05;

    return new google.maps.LatLng(parseFloat(latlng[0]) + la, parseFloat(latlng[1]) + lo);
}

var imageSources = new Object();

function addSource(post) {
    var imgSrc = "img/vege-card.jpg";
    $.get("./php/images.php", {postid: post.id}, function (data)
    {
        try
        {
            console.log(data);
            var urls = JSON.parse(data);
            console.log(urls);
            var photo = urls[urls.length - 1];
            photo.replace('\\', '');
	    if (photo.length > 0) {
		imgSrc = photo;
		imageSources[post.id] = imgSrc;
	    }
        }
        catch(e){
	    console.log(e);
	    imgSrc = "img/vege-card.jpg";
	    imageSources[post.id] = imgSrc;
	}
    });
}

function createPopup(post)
{
    var imgSrc = imageSources[post.id];
    console.log("<h3>" +  post.title + "</h3><br/><img class='smallimg' src='" + imgSrc + "'><br/>" + post.description);
    return "<h3>" +  post.title + "</h3><br/><img class='smallimg d-block mx-auto' src='" + imgSrc + "'><p class='text-xs-center'>" + post.description + "</p>";
}

var infowindow;
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
        m.index = i;

        google.maps.event.addListener(m, "click", function(){window.location.replace("listing.php?id=" + window.posts[this.index].id)});
        google.maps.event.addListener(m, "mouseover", function()
        {
            infowindow = new google.maps.InfoWindow({content: createPopup(window.posts[this.index])});
            infowindow.open(map, this);
        });
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

function findGetParameter(parameterName)
{
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++)
    {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

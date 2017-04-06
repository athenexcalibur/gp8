// USE THIS SCRIPT TO SHOW THE IMAGE FOR THE ITEM ID SPECIFIED IN data-itemid
// FILL THE PAGE WITH DIVS OF THE CLASS itemimage, SET THIER data-itemid AND THEN RUN THIS SCRIPT TO ADD THE SAVED IMAGE / DEFAULT IMAGE TO THEM

var photosDiv = $(".itemimage");
var id = photosDiv.attr("data-itemid");
photosDiv.html("");
$.get("./php/images.php", {postid: id}, function (data)
{
  var imgSrc = "img/vege-card.jpg"
  try
  {
    var urls = JSON.parse(data);
    for (var i = 0; i < urls.length; i++)
    {
      var photo = urls[i];
      photo.replace('\\', '');
      imgSrc = photo;
    }
  }
  catch (e)
  {
    imgSrc = "img/vege-card.jpg"
  }

  photosDiv.html("<img src='" + imgSrc + "'>");
});

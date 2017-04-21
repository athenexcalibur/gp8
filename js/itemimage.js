// USE THIS SCRIPT TO SHOW THE IMAGE FOR THE ITEM ID SPECIFIED IN data-itemid
// FILL THE PAGE WITH IMGS OF THE CLASS itemimage, SET THIER data-itemid AND THEN RUN THIS SCRIPT TO ADD THE SAVED IMAGE / DEFAULT IMAGE TO THEM

function fixImgs()
{
  $.each($(".itemimage"), function(){
    fix($(this));
  });
}

function fixImg(card)
{
  fix(card.find(".itemimage"));
}

function addAllImgs()
{
  $.each($(".allitemimages"), function(){
    addAllImg($(this));
  });
}

function addAllImg(div)
{
  var id = div.attr("data-itemid");
  $.get("php/images.php?postid=" + id, function(data)
  {
    try
    {
      var images = JSON.parse(data);
      div.append("<div class ='carousel-item active'><div class='view hm-grey-slight'><img src='" + images[0] + "' alt='IMAGE'></div></div>");
      for(var i = 1; i < images.length; i++)
      {
        div.append("<div class ='carousel-item'><div class='view hm-grey-slight'><img src='" + images[i] + "' alt='IMAGE'></div></div>");
      }

      if(images.length == 0)
      {
	  div.html("<div class ='carousel-item active'><div class='view hm-grey-slight'><img src='" +  "img/vege-card.jpg" + "' alt='IMAGE'></div></div>");
      }
    }
    catch(e)
    {
      div.html("<div class ='carousel-item active'><div class='view hm-grey-slight'><img src='" +  "img/vege-card.jpg" + "' alt='IMAGE'></div></div>");
    }
  });
}

function fix(imgview)
{
  var id = imgview.attr("data-itemid");
  $.get("./php/images.php", {postid: id}, function (data)
  {
    var imgSrc = "img/vege-card.jpg";
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
    catch(e)
    {
      imgSrc = "img/vege-card.jpg"
    }
    //console.log("itemimgs for " + id + " : " + imgSrc);

    imgview.attr("src", imgSrc);
  });
}

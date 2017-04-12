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

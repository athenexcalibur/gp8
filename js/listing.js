$("#delBtn").on("click", function()
{
  $.post("php/post/postTools.php",
  {postID: $(this).data("pid"), cancel: true} ,
  function(data){
    console.log(data);
    //window.location.href="orders.php";
  }
  );
});

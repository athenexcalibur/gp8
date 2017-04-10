$("#deleteBtn").on("click", function()
{
  $.post("php/post/postTools.php",
  {postID: $(this).data("pid"), delete: true} ,
  function(data){
    console.log(data);
    window.location.href="orders.php";
  }
  );
});

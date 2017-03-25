$("#delBtn").on("click", function()
{
    $.post("php/post/post.php",
        {id: $(this).data("pid"), delete: true},
    function(data){window.location.href="index.php";});
});
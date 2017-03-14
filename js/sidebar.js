//setup sidebar
var snapper = new Snap({
    element: document.getElementById('content'),
    disable: "left",
    transitionSpeed: 0.7
});
//setup toggle button
$("#open-right").click(function() {
    if( snapper.state().state=="right" ){
	snapper.close();
    } else {
	snapper.open('right');
    }
});
//fade out main page content on sidebar open
snapper.on("animating", function(){
    if(snapper.state().state=="closed")
	$(".snap-content>.mask").fadeOut();
    else
	$(".snap-content>.mask").fadeIn();
});
//cool wave effect on item click
Waves.attach('.snap-drawers .nav-link', ['waves-effect']);

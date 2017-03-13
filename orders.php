<!DOCTYPE html>
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--snap stuff-->
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <link rel="stylesheet" type="text/css" href="snap/snap.css" />

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

  <!-- Material-Design icon library -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Bootstrap Core Stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/bootstrap.min.css">

  <!-- Material-Design core stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/mdb.min.css">

  <!-- My Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/orders.css">

</head>

<body onload="fillOrders()">
  <div class="snap-drawers">
    <div class="snap-drawer snap-drawer-right">
      <div>
	<ul>
	  <li>Orders</li>
	  <li>Listings</li>
	  <li>Messages</li>
	  <li>Notifications</li>
	  <li>Account</li>
	</ul>
      </div>
    </div>
  </div>
  <div id="content" class="snap-content">
    <header>
      <!-- navbar -->
      <nav class="navbar navbar-dark navbar-fixed-top elegant-color-dark">
	<a href="#" id="open-left" class="navbar-brand">LOGO</a>
	<ul class="nav navbar-nav pull-right">
	  <!--<li class="nav-item">-->
	  <!--<a class="nav-link">Login</a>-->
	  <!--</li>-->
	  <li class="nav-item">
	    <a href="#" id="open-right" class="nav-link"><i class="material-icons">account_circle</i></a>
	  </li>
	</ul>
      </nav>
      <!--/.navbar -->
    </header>


    <main>


    <div id="ordersWrapper" class="container">

      <div id="header">
	<h2>Your Orders</h2>
      </div>
      <div class="row">
	<nav class="nav">
	  <ul class="nav nav-tabs justify-content-center">
	    <li class="nav-item">
	      <a class="nav-link active" href="#current" data-toggle="tab">Current</a>
	    </li>
	    <li class="nav-item">
	      <a class="nav-link" href="#history" data-toggle="tab">History</a>
	    </li>
	  </ul>
	</nav>

	<div class="tab-content">
	  <div class="tab-pane active" id="current" role="tabpanel">
	    <div class="card order-cards">
	    </div>
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#recievedModal">RECIEVED</button>
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cancelmodal">CANCEL</button>
	  </div>
	  <div class="tab-pane" id="history" role="tabpanel">
	    <div class="card past-order-card">
	    </div>
	  </div>
	</div>

      </div>

    </div>
		
	

    </main>


    <footer>

    </footer>
  </div>
  
  <!-- Modal -->
<div class="modal fade" id="recievedModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Please rate this item and your experience</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
               <form>
				  <input type="radio" name="rating" value="1" checked> 1 *<br>
				   <input type="radio" name="rating" value="2" checked> 2 *<br>
				    <input type="radio" name="rating" value="3" checked> 3 *<br>
					 <input type="radio" name="rating" value="4" checked> 4 *<br>
					  <input type="radio" name="rating" value="5" checked> 5 *<br>
				</form> 
            </div>
            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="submitrating()" data-dismiss="modal">SUBMIT</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<!-- modal to cancel -->
<div class="modal fade" id="cancelmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">To FoodieDave</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
               <div class="md-form">
				<input type="text" value = "Hi FoodieDave! I am sorry, I have to cancel this order" class="form-control">
				<label for="form1" class="">Message</label>
			</div>
			</div>
            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="submitrating()" data-dismiss="modal">SEND</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

  <!--Scripts-->
  <script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
  <script src="bootstrap-material-design/js/tether.min.js"></script>
  <script src="bootstrap-material-design/js/bootstrap.min.js"></script>
  <script src="bootstrap-material-design/js/mdb.min.js"></script>
  <script src="js/cards.js"></script>
  <script src="js/searchbar.js"></script>
  
  <script type="text/javascript">
   function fillOrders()
   {
	   /*
	   var html = "";
	   var url = "" //php to get user's current orders
	   $.get(url, function(data)
	   {
		var orders = JSON.parse(data);
		document.getElementById("message").innerHTML = html;
	   });*/
	   
		for(var i = 0; i < 4; i++)
		{
			//var order = orders[i];
			$.get("ajax/orderCard.html", function(data) {
				$(".order-cards").append(data);
			})
			var card = $('.order-cards:nth-child(' + i + ')');
			card.attr('id', i);
			//document.getElementById("#" + i + ".foodname")
			console.log(card.find(".foodname"));
			//html += order[]
		}
   }
   
   function submitrating()
   {
	   var rating = $("input[name=rating]:checked").val();
	   console.log(rating);
	   var url = "php/finalisePost.php?postID=" + postID + "&rating=" + rating;
	   $.post(url);
	   fillOrders();
   }
   </script>

  <script type="text/javascript" src="snap/snap.min.js"></script>
  <script type="text/javascript">
      var snapper = new Snap({
          element: document.getElementById('content')
      });
  </script>
  <!--/.Scripts-->
</body>

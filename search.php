<?php
require_once "php/user.php";
require_once "php/database.php";
cSessionStart();
if (!loginCheck())
{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--snap stuff-->
    <meta http-equiv="x-ua-compatible" content="IE=edge"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <link rel="stylesheet" type="text/css" href="snap/snap.css"/>

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
    <link rel="stylesheet" href="css/search.css">

</head>

<body>
<div class="snap-drawers">
    <div class="snap-drawer snap-drawer-right elegant-color-dark">
        <ul class="nav flex-column">
            <div class="view overlay hm-white-slight">
                <li class="nav-item">
                    <a class="nav-link" href="orders.php">Orders</a>
                    <div class="mask"></div>
                </li>
            </div>
            <div class="view overlay hm-white-slight">
                <li class="nav-item">
                    <a class="nav-link" href="mylistings.php">Listings</a>
                    <div class="mask"></div>
                </li>
            </div>
            <div class="view overlay hm-white-slight">
                <li class="nav-item">
                    <a class="nav-link" href="inbox.php">Messages</a>
                    <div class="mask"></div>
                </li>
            </div>
            <div class="view overlay hm-white-slight">
                <li class="nav-item">
                    <a class="nav-link" href="#">Notifications</a>
                    <div class="mask"></div>
                </li>
            </div>
            <div class="view overlay hm-white-slight">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Account</a>
                    <div class="mask"></div>
                </li>
            </div>
        </ul>
    </div>
</div>
<div id="content" class="snap-content">
    <div class="mask"></div>
    <header>
        <!-- navbar -->
        <nav class="navbar navbar-dark navbar-fixed-top elegant-color-dark">
            <a href="/" id="open-left" class="navbar-brand">LOGO</a>
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

        <div class="container search-container">
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8">
                    <form>
                        <div class="input-group">
                            <div id="showFilters" class="input-group-addon"><i class="material-icons">menu</i></div>
                            <input class="form-control" type="text" id="searchBox" placeholder="Search">
                            <div class="input-group-addon"><i class="material-icons">search</i></div>
                        </div>
                    </form>

                    <br>
                    <br>

                    <div class="search-options-container">
                        <div class="row">
                            <div class="col-md-6" class="allergyBoxes">
                                <h4>Dietary Requirements</h4>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="HALAL"
                                            <?php if ($_SESSION["user"]->checkFlag(HALAL)) { echo("checked"); }?>> Halal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="KOSHER"
                                            <?php if ($_SESSION["user"]->checkFlag(KOSHER)) { echo("checked"); }?>> Kosher
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"  value="VEGETARIAN"
                                            <?php if ($_SESSION["user"]->checkFlag(VEGETARIAN)) { echo("checked"); }?>> Vegeterian
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="VEGAN"
                                            <?php if ($_SESSION["user"]->checkFlag(VEGAN)) { echo("checked"); }?>> Vegan
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6" class="allergyBoxes">
                                <h4>Allergies</h4>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="PEANUT"
                                            <?php if ($_SESSION["user"]->checkFlag(PEANUT)) { echo("checked"); }?>> Peanuts
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="GLUTEN"
                                            <?php if ($_SESSION["user"]->checkFlag(GLUTEN)) { echo("checked"); }?>> Gluten
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="SOY"
                                            <?php if ($_SESSION["user"]->checkFlag(SOY)) { echo("checked"); }?>> Soy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="LACTOSE"
                                            <?php if ($_SESSION["user"]->checkFlag(LACTOSE)) { echo("checked"); }?>> Lactose
                                    </label>
                                </div>
                            </div>

                            <div class="dropdown" id="sortBy">
                                <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span id="selected">Distance</span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Distance</a></li>
                                    <li><a href="#">Soonest Expiry</a></li>
                                    <li><a href="#">Most Recent</a></li>
                                    <li><a href="#">User Rating</a></li>
                                    <li><a href="#">User Score</a></li>
                                </ul>
                            </div>

                            <div id="refineBtn">
                                <button type="button" class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2"></div>
            </div>
        </div>

        <div class="container" id="results">
        </div>
    </main>


    <footer>

    </footer>
</div>

<!--Scripts-->
<script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
<script src="bootstrap-material-design/js/tether.min.js"></script>
<script src="bootstrap-material-design/js/bootstrap.min.js"></script>
<script src="bootstrap-material-design/js/mdb.min.js"></script>
<script src="js/search.js"></script>

<script type="text/javascript" src="snap/snap.min.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
<!--/.Scripts-->
</body>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Home - JailbreakHub</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- CSS -->

    <link href="css/web.css" rel="stylesheet">
    <link rel="shortcut icon" href="../favicon.ico">
		
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
		
    <link rel="stylesheet" type="text/css" href="css/loading.css" />
		
    <link rel="stylesheet" type="text/css" href="css/loading_effect.css" />
		    <script src="js/modernizr.custom.js"></script>


    <!-- Template styles -->
    <style rel="stylesheet">
        
        main {
            padding-top: 3rem;
            padding-bottom: 2rem;
        }
        
        .widget-wrapper {
            padding-bottom: 2rem;
            margin-bottom: 2rem;
			}

    </style>

</head>

<body>
<div id="ip-container" class="ip-container">
<header class="ip-header">
																
								<div class="ip-loader">
					<svg class="ip-inner" width="125px" height="125px" viewBox="00 0 80 80">
						<path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
						<path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
					</svg>
				</div>
			</header>
 <div class="ip-main">
    <header>

        <!--Navbar-->
        <nav class="navbar navbar-dark primary-color-dark">

            <!-- Collapse button-->
            <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx">
                <i class="fa fa-bars"></i>
            </button>

            <div class="container">

                <!--Collapse content-->
                <div class="collapse navbar-toggleable-xs" id="collapseEx">
                    <!--Navbar Brand-->
                    <!--Links-->
                    <ul class="nav navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="posts.html">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">Current Jailbreak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Socials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Downloads</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Tweaks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Themes</a>
                        </li>
                    </ul>
                    <!--Search form-->
                    <form class="form-inline">
                        <input class="form-control" type="text" placeholder="Search">
                    </form>
                </div>
                <!--/.Collapse content-->

            </div>

        </nav>
        <!--/.Navbar-->

    </header>

    <main>

        <!--Main layout-->
        <div class="container">
            <div class="row">

                <!--Main column-->
                <div class="col-lg-8">
                    <?php
                    include("backend/show_news.php");
                    ?>

                    <!--Pagination-->
                    <nav class="text-xs-center">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!--/.Pagination-->

                    <hr>

                </div>

                <!--Sidebar-->
                <div class="col-lg-4">

                    <div class="widget-wrapper">
                        <h4>Recent Posts:</h4>
                        <br>
                        <div class="list-group">
                            <a href="#" class="list-group-item Written">
                            <?php
                                $static = true;
                                $template = "Headlines";
                                $number = "1";
                                include("backend/show_news.php");
                            ?>
                            </a>
                            <a class="list-group-item Written">
                                <?php
                                $static = true;
                                $template = "Headlines";
                                $number = "1";
                                include("backend/show_news.php");
                                ?>
                            </a>
                            <a class="list-group-item Written">
                                <?php
                                $static = true;
                                $template = "Headlines";
                                $number = "1";
                                include("backend/show_news.php");
                                ?>
                            </a>
                            <a class="list-group-item Written">
                                <?php
                                $static = true;
                                $template = "Headlines";
                                $number = "1";
                                include("backend/show_news.php");
                                ?>
                            </a>
                        </div>
                    </div>
                </div>
                <!--/.Sidebar-->
            </div>
        </div>
        <!--/.Main layout-->

    </main>

    <!--Footer-->
    <footer class="page-footer center-on-small-only primary-color-dark">

        <!--Footer Links-->
        <div class="container-fluid">
            <div class="row">
<div class="col-md-3 offset-lg-1 hidden-lg-down">
                    <h5 class="title">Jailbreak Hub</h5>
                    <p>JailbreakHub is a website for all jailbreak related content on iPhone, iPod, and iPad</p>
                </div>

                <!--First column-->
              
                <!--/.First column-->

                <hr class="hidden-md-up">

                <!--Second column-->
                <div class="col-lg-2 col-md-4 offset-lg-1">
                    <h5 class="title">First column</h5>
                    <ul>
                        <li><a class="lihover" href="#!">Link 1</a></li>
                        <li><a class="lihover" href="#!">Link 2</a></li>
                        <li><a class="lihover" href="#!">Link 3</a></li>
                        <li><a class="lihover" href="#!">Link 4</a></li>
                    </ul>
                </div>
                <!--/.Second column-->

                <hr class="hidden-md-up">

                <!--Third column-->
                <div class="col-lg-2 col-md-4">
                    <h5 class="title">Second column</h5>
                    <ul>
                        <li><a class="lihover" href="#!">Link 1</a></li>
                        <li><a class="lihover" href="#!">Link 2</a></li>
                        <li><a class="lihover" href="#!">Link 3</a></li>
                        <li><a class="lihover" href="#!">Link 4</a></li>
                    </ul>
                </div>
                <!--/.Third column-->

                <hr class="hidden-md-up">

                <!--Fourth column-->
                <div class="col-lg-2 col-md-4">
                    <h5 class="title">Third column</h5>
                    <ul>
                        <li><a class="lihover" href="#!">Link 1</a></li>
                        <li><a class="lihover" href="#!">Link 2</a></li>
                        <li><a class="lihover" href="#!">Link 3</a></li>
                        <li><a class="lihover" href="#!">Link 4</a></li>
                    </ul>
                </div>
                <!--/.Fourth column-->

            </div>
        </div>
        <!--/.Footer Links-->

        <hr>

        <!--Call to action-->
        <div class="call-to-action">
            <h4>Title</h4>
            <ul>
                <li>
                    <h5>Something here</h5></li>
                <li><a target="_blank" href="" class="btn btn-danger">Sign up!</a></li>
                <li><a target="_blank" href="" class="btn btn-default">Learn more</a></li>
            </ul>
        </div>
        <!--/.Call to action-->

        <!--Copyright-->
        <div class="footer-copyright">
            <div class="container-fluid">
                ©2017 <a href="copyright.html"> Your Corporation</a>

            </div>
        </div>
</div>
        <!--/.Copyright-->

    </div>
    <!--/.Footer-->


    <!-- SCRIPTS -->
<script src="js/classie.js"></script>
		<script src="js/pathLoader.js"></script>
		<script src="js/loading.js"></script>

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-2.2.3.js"></script>

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/tether.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/web.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90532905-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- test -->
</body>

</html>

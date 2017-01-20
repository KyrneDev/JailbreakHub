<?php
include("./template/head.php")
?>

        <!--Main layout-->
        <div class="container">
            <div class="row">

                <!--Main column-->
                <div class="col-lg-8">

                    <!--Post-->
                                        <div class="post-wrapper">
                        <!--Post data-->


                        <h1 class="h1-responsive">TO DO:<small class="text-muted"> Make it a bit less like google lmao or were gonna get sued</small></h1>
                        <h5>Written by <a class="Written" href="">John Doe</a>, 30.04.2016</h5>

                        <br>

                        <!--Featured image -->
                        <div class="view overlay hm-white-light z-depth-1-half">
                            <img src="" class="img-fluid " alt="">
                            <div class="mask">
                            </div>
                        </div>

                        <br>

                        <!--Post excerpt-->
                        <p>text here</p>

                        <!--"Read more" button-->
                        <button class="btn btn-primary">Read more</button>
                    </div>
                    <!--/.Post-->

                    <hr>

                    <!--Post-->
                    <div class="post-wrapper">
                        <!--Post data-->
                        <h1 class="h1-responsive">Post title <small class="text-muted">Secondary text</small></h1>
                        <h5>Written by <a class="Written" href="">John Doe</a>, 30.04.2016</h5>

                        <br>

                        <!--Featured image -->
                        <div class="view overlay hm-white-light z-depth-1-half">
                            <img src="" class="img-fluid " alt="">
                            <div class="mask">
                            </div>
                        </div>

                        <br>

                        <!--Post excerpt-->
                        <p>text here</p>

                        <!--"Read more" button-->
                        <button class="btn btn-primary">Read more</button>
                    </div>
                    <!--/.Post-->

                    <hr>

                    <!--Post-->
                    <div class="post-wrapper">
                        <!--Post data-->
                        <h1 class="h1-responsive">Post title <small class="text-muted">Secondary text</small></h1>
                        <h5>Written by <a class="Written" href="">John Doe</a>, 30.04.2016</h5>

                        <br>

                        <!--Featured image -->
                        <div class="view overlay hm-white-light z-depth-1-half">
                            <img src="" class="img-fluid" alt="">
                            <div class="mask">
                            </div>
                        </div>

                        <br>

                        <!--Post excerpt-->
                        <p>text here</p>

                        <!--"Read more" button-->
                        <button class="btn btn-primary">Read more</button>
                    </div>
                    <!--/.Post-->

                    <hr>

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
                        <h4>Categories:</h4>
                        <br>
                        <div class="list-group">
                            <a href="#" class="list-group-item Writtena active">Sport</a>
                            <a href="#" class="list-group-item Written">Music</a>
                            <a href="#" class="list-group-item Written">Travels</a>
                            <a href="#" class="list-group-item Written">Fashion</a>
                            <a href="#" class="list-group-item Written">Parties</a>
                        </div>
                    </div>



                     <div class="widget-wrapper">
                        <h4>Subscription form:</h4>
                        <br>
                        <div class="card">
                            <div class="card-block">
                                <p><strong>Subscribe to our newsletter</strong></p>
                                <p>Once a week we will send you a summary of the most useful news</p>
                                <div class="md-form">
                                    <i class="fa fa-user prefix"></i>
                                    <input type="text" id="form1" placeholder="Your name" class="form-control">
                                </div>
                                <div class="md-form">
                                    <i class="fa fa-envelope prefix"></i>
                                    <input type="text" id="form2" placeholder="Your email" class="form-control">
                                </div>
                                <button class="btn btn-primary">Submit</button>

                            </div>
                        </div>
                    </div>

                </div>
                <!--/.Sidebar-->
            </div>
        </div>
        <!--/.Main layout-->

  <?php
include("./template/footer.php")
?>

<!-- contains the head of the file with css, and javascript setup.
Incude this head.php so changes can be made in one place, and applied to the entire website.
Be sure to also include footer.php to incude the footer throughout the entire website.
-->
<?php
include("./template/head.php")
?>

            <!--Main layout-->
            <div class="container">
                <div class="row">

                    <!--Main column-->
                    <div class="col-lg-8">
                        <?php
                        $number = "1";
                        include("backend/show_news.php");
                        ?>

                        <!--Pagination-->
                        <nav class="text-xs-center">
                            <div id=pages>
                                <!--<ul class="pagination">
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
</ul>-->
                            </div>
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

                                <?php
                                $static = true;
                                $template = "Headlines";
                                $number = "5";
                                include("backend/show_news.php");
                                ?>

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

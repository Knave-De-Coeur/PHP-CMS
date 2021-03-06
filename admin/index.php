<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <?php



        $user_post_published_count = checkStatus('posts', 'status', 'published', true);


        $user_post_draft_count = checkStatus('posts', 'status', 'draft', true);


        $user_unapproved_comment_count = countRecords(getAllPostUserCommentsWithStatus('unapproved'));


        $user_approved_comment_count = countRecords(getAllPostUserCommentsWithStatus('approved'));

        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <small>Role: <?php echo $_SESSION['role']; ?></small>
                            Welcome to Admin!
                            <?php echo strtoupper(getUsername()); ?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->


                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $post_count = recordCount('posts', true); ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $comment_count = countRecords(getAllPostUserComments()); ?></div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $cat_count = countRecords(getAllPostUserCategories()); ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->




                <div class="row">


                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],



                                <?php

                                $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Active Comments', 'Pending Comments', 'Categories'];
                                $element_count = [$post_count, $user_post_published_count, $user_post_draft_count, $user_approved_comment_count, $user_unapproved_comment_count, $cat_count];

                                for ($i = 0; $i < count($element_text); $i++) {
                                    echo "['$element_text[$i]'" . "," . $element_count[$i] . "],";
                                }

                                ?>
                            ]);

                            var options = {
                                chart: {
                                    title: '',
                                    subtitle: '',
                                }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>

                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>

<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>

    $(document).ready(function () {

        var pusher = new Pusher('4bdbf68110d0eadc5615', {
            cluster: 'eu',
            encrypted: true
        });

        var notificationChannel =  pusher.subscribe('notifications');

        notificationChannel.bind('new_user', function (notification) {
           var message = notification.message;

           toastr.success(`${message} just registered`);

           console.log(JSON.stringify(notification));
        });

    });

</script>
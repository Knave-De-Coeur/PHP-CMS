<?php  include "includes/db_connection.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

<?php

    if(isset($_POST['submit'])) {
        $to         = "alexanderm.1496@gmail.com";
        $subject    = $_POST['subject'];
        $body       = wordwrap($_POST['body'], 70);
        $header     = "From: " . $_POST['email'];

        mail($to, $subject, $body, $header);

        $message = "Email sent";
    }



?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <?php

                        if(isset($message)) {
                            echo "<h6 class=\"bg-success\">$message</h6>";
                        }

                        ?>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Desired Subject">
                        </div>
                         <div class="form-group">
                            <label for="body" class="sr-only">Body</label>
                             <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>

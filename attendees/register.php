<?php

require 'header.php';

$failed = $_GET[failed];

?>


	<h1>Teacher Registration</h1>
    
    <div style="max-width: 350px; margin-left:auto; margin-right:auto;">
        <?php if($failed ==true) { echo '<br /><div class="alert alert-warning" role="alert"><p><strong>Oops:</strong> something didn\'t work, please try again.</p></div>'; } ?>
        <form action="register_format.php" method="post">
            <p><strong>Site Name:</strong><input type="text" name="decdsite" placeholder="DECD Site" class="form-control" required></p>
            <p><strong>Your First Name:</strong><input type="text" name="firstname" placeholder="First Name" class="form-control" required> <small>We only need your first name, so we know who to say hello to when you login.</small></p>
            <p><strong>Email Address:</strong><input type="email" name="emailaddress" placeholder="firstname.lastname123@schools.sa.edu.au" class="form-control" required><small>We hate spam as much as you do. You will be able to opt-in to a low-traffic mailing list once your registration is complete. No pesky unwanted messages here!</small></p>
            <p><strong>Password:</strong><input type="password" name="password" placeholder="password123" class="form-control" required> <small>Make it a good one, contrary to popular belief, your password doesn't have to be some crazy assortment of symbols - just long, and unique.</small></p>
            <p class="text-center"><button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok"></span> Register</button><div class="clearfix"></div></p>
        </form>
    </div>

<?php

require 'footer.php';

?>

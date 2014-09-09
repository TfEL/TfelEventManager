<?php

require 'header.php';

$failed = $_GET[failed];

?>

<div class="page-header">
	<h2>Teaching for Effective Learning Events</h2>
	<p class="lead">Login to speed up registrations</p>
</div>

	<h1>Login</h1>

    <div style="max-width: 320px; margin-left:auto; margin-right:auto;">
        <?php if($failed ==true) { echo '<br /><div class="alert alert-warning" role="alert"><p><strong>Oops:</strong> incorrect login, please try again.</p></div>'; } ?>
        <form action="login_format.php" method="post">
            <p><strong>Email Address:</strong><input type="email" name="emailaddress" placeholder="firstname.lastname123@schools.sa.edu.au" class="form-control" required="required"><small>This will typically be your @schools.sa.edu.au or @sa.gov.au email.</small></p>
            <p><strong>Password:</strong><input type="password" name="password" placeholder="password123" class="form-control" required="required"></p>
            <p class="text-center"><button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok"></span> Log In</button><div class="clearfix"></div></p>
        </form>
    </div>

<?php

require 'footer.php';

?>
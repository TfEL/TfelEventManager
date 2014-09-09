
<?php if(empty($userData) || $userData == false) { ?>
 <div class="footer"><hr> <p class="pull-right">For faster registration, <a href="/attendees/login.php">login</a> or <a href="/attendees/register.php">register</a>. Event coordinators <a href="../manager/">login</a>.</p> <p>&copy; Department for Education and Child Development.<p> </div>
<?php } else { ?>
 <div class="footer"><hr> <p class="pull-right">Logged In. Event coordinators <a href="../manager/">login</a>.</p> <p>&copy; Department for Education and Child Development.<p> </div>
<?php } ?>
   </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>

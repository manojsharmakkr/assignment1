<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_NOTICE);
?>
<h1>Shop Online</h1>
<div class="menu">
    <ul>
        <li><a href="./" title="Home">Home</a></li>       
        <?php if ($_SESSION['username']) { ?>
            <li><a href="listing.htm" title="Listing">Listing</a></li>                        
            <li><a title="Bidding" href="bidding.htm">Bidding</a></li>                        
            <li><a title="Maintenance" href="maintenance.htm">Maintenance</a></li>    
            <li><a href="logout.php" title="Log Out">Log Out</a></li>
        <?php } else { ?>
            <li><a href="login.htm" title="Login">Login</a></li>
        <?php } ?>

    </ul>
</div>
<hr/>
<?php
/*
 * Start sesstion
 * set SESSION USER is null
 */
session_start();
$_SESSION['username'] = null;
?>
<html>
    <head>
        <script type="text/javascript">
            sessionStorage.username = '';
            location.href = "index.php";
        </script>    
    </head>
    <body>

    </body>
</html>

<?php 
	session_start();

	session_destroy();
    unset ($_SESSION["user"]);
?>
<script>
            (function () {
                window.location = '../index.php';
            })();
</script>
<?php
    require 'include/rb_db.php';
    unset($_SESSION['logged_user']);
    echo '<script type="text/javascript">'; 
    echo 'window.location.href="index.php";'; 
    echo '</script>';
?>
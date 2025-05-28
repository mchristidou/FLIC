<?php
    function echo_msg(){
        if (isset($_SESSION['msg'])) {
            echo '<p style="color:purple;">'.$_SESSION['msg'].'</p>';
            unset($_SESSION['msg']);
        } elseif (isset($_GET['msg'])) {
            $encoded = htmlspecialchars($_GET['msg']);
            echo '<p style="color:purple;">'.$encoded.'</p>';
        }
    }
?>
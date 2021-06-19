<?php

session_start();

if (isset($_GET['sign_out'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
}

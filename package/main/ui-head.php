<?php session_start();
include('../../config/config.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SolarSmart</title>
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>css/datatables.min.css">
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>css/sweetalert.css">


    <script src="<?php echo WEB_URL; ?>js/jquery.min.js"></script>
    <script src="<?php echo WEB_URL; ?>js/loader.js"></script>
    <script src="<?php echo WEB_URL; ?>js/datatables.min.js"></script>
    <script src="<?php echo WEB_URL; ?>js/bootstrap.js"></script>
    <script src="<?php echo WEB_URL; ?>js/sweetalert.js"></script>
    <script src="<?php echo WEB_URL; ?>js/popper.js"></script>
    <style>
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a href="<?php echo WEB_URL; ?>package/main/dashboard.php" class="navbar navbar-brand">SolarSmart</a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="<?php echo WEB_URL; ?>package/main/dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Users</a>
                    <div class="dropdown-menu">
                        <a href="<?php echo WEB_URL; ?>package/user/user-list.php" class="dropdown-item">User List</a>
                        <a href="<?php echo WEB_URL; ?>package/user/user-registration.php" class="dropdown-item">Registration</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Section</a>
                    <div class="dropdown-menu">
                        <a href="<?php echo WEB_URL; ?>package/section/section-list.php" class="dropdown-item">Section List</a>
                        <a href="<?php echo WEB_URL; ?>package/section/section-create.php" class="dropdown-item">Section create</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Device</a>
                    <div class="dropdown-menu">
                        <a href="<?php echo WEB_URL; ?>package/device/device-list.php" class="dropdown-item">Device List</a>
                        <a href="<?php echo WEB_URL; ?>package/device/device-create.php" class="dropdown-item">Device create</a>
                    </div>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo WEB_URL; ?>package/user/profile.php" class="btn">My Account</a>
                </li>
                <li>
                    <form method="get" action="<?php echo htmlspecialchars(WEB_URL.'content/sign-out.php'); ?>">
                        <button type="submit" name="sign_out" value="sign_out" class="btn btn-outline-success">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

<?php
include('../main/ui-head.php');
include('../../content/function.php');

$error = array();
$userInfo = array();

$dbQuery = "SELECT * FROM `users` where `userId`='".$_SESSION['userId']."';";

if ($result = mysqli_query($conn, $dbQuery)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userInfo['fName'] = $row['fName'];
            $userInfo['lName'] = $row['lName'];
            $userInfo['dispName'] = $row['dispName'];
            $userInfo['addr'] = $row['addr'];
            $userInfo['telNum'] = $row['telNum'];
            $userInfo['nic'] = $row['nic'];
            $userInfo['email'] = $row['email'];
            $userInfo['proImg'] = $row['proImg'];
        }
    }
}

if (isset($_POST['update'])) {

    if (empty($_POST["fname"])) {
        $error['fname'] = "Enter first name";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['fname'])) {
            $error['fname'] = "Use the letters for first name";
        } else {
            $firstName = check_input($_POST['fname']);
        }
    }

    if (empty($_POST["lname"])) {
        $error['lname'] = "Enter last name";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['lname'])) {
            $error['lname'] = "Use the letters for last name";
        } else {
            $lastName = check_input($_POST['lname']);
        }
    }

    if (empty($_POST["dispName"])) {
        $error['dispName'] = "Enter display name";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['dispName'])) {
            $error['lname'] = "Use the letters for display name";
        } else {
            $disName = check_input($_POST['dispName']);
        }
    }

    if (empty($_POST["address"])) {
        $error['address'] = "Enter address";
    } else {
        $address = check_input($_POST['address']);
    }

    if (empty($_POST['nic'])) {
        $error['nic'] = "nic is empty";
    } else {
        $nic = check_input($_POST['nic']);
        if (check_duplicate_nic($nic) == true) {
            $error['nic'] = "duplicate nic";
        } else {
            if (strlen($nic) == 10) {
                for ($i = 0; $i < strlen($nic); $i++) {
                    if ($i == 9) {
                        if (substr($nic, $i, 1) != 'V') {
                            $error['nic'] = "nic is invalid";
                            break;
                        }
                    } else {
                        if (!is_numeric(substr($nic, $i, 1))) {
                            $error['nic'] = "nic is invalid";
                            break;
                        }
                    }
                }
            } else if (strlen($nic) == 12) {
                if(!is_numeric($nic)) {
                    $error['nic']="nic is invalid";
                }

            } else {
                $error['nic'] = "Oops!, Your ID card is not in 10/12 digits.";
            }
        }
    }

    if (empty($_POST["mNumber"])) {
        $error['mNumber'] = "Enter mobile number";
    } else {
        $mNumber = check_input($_POST['mNumber']);
    }

    if (!($_FILES['file']['name'] == null)) {
        $imageExt = explode('.', $_FILES['file']['name']);
        $imageActualExt = strtolower(end($imageExt));
        $allowed = array('jpg', 'jpeg', 'png');

        if (!(in_array($imageActualExt, $allowed))) {
            $error['uploadError'] = "Can not upload format of this image";
        }
        if (!($_FILES['file']['error'] == 0)) {
            $error['uploadError'] = "There are some error this image";
        }
        if ($_FILES['file']['size'] > 7000000) {
            $error['uploadError'] = "Image size long of this image";
        }

        if (!isset($error['uploadError'])) {
            $imageNewName = uniqid('', true) . "." . $imageActualExt;
            $imageDestination = '../../res/img/' . $imageNewName;
            move_uploaded_file($_FILES['file']['tmp_name'], $imageDestination);
            $_SESSION['proImg'] = $imageNewName;
            $userInfo['proImg'] = $imageNewName;
        }
    }

    $errorCount = count($error);

    if (0 === $errorCount) {
        $userRegQuery = "UPDATE `users` SET `fName`='$firstName',`lName`='$lastName',`dispName`='$disName',`addr`='$address',`telNum`='$mNumber',`nic`='$nic',`proImg`='".$userInfo['proImg']."' WHERE  userId='".$_SESSION['userId']."';";

        if (mysqli_query($conn, $userRegQuery)) {
            echo '<script>swal("Update success!")</script>';
        }
    }
}

function check_duplicate_nic($nic)
{
    global $conn;
    $dbQuery = "SELECT userId FROM users WHERE nic = '".$nic."' AND userId != '".$_SESSION['userId']."';";
    $dbResult = mysqli_query($conn, $dbQuery);
    if ($dbResult && mysqli_num_rows($dbResult) == 1) {
        return true;
    } else {
        return false;
    }
}
?>
    <div class="container mt-5">
        <div class="row">
            <h3 class="display-4 h6"><?php echo $_SESSION['dispName']; ?></h3>
        </div>
        <form method="post" action="profile.php" class="mt-4" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="profile-img">
                        <img src="<?php echo WEB_URL; ?>/res/img/<?php echo $_SESSION['proImg']; ?>"
                             alt="profile image" width="50%" />
                        <?php if (isset($error['uploadError'])) { echo '<label class="form-text text-danger">'.$error['uploadError'].'</label>'; } ?>
                        <input class="mt-2 form-control-file" name="file" type="file" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First name</label>
                    <input type="text" name="fname" class="form-control <?php if (isset($error['fname'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['fname'])): echo 'value="'.$_POST['fname'].'"'; endif; ?> placeholder="Saman"
                           value="<?php echo $userInfo['fName']; ?>" />
                    <?php if (isset($error['fname'])) : echo '<label class="invalid-feedback">'.$error['fname'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Last name</label>
                    <input type="text" name="lname" class="form-control <?php if (isset($error['lname'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['lname'])): echo 'value="'.$_POST['lname'].'"'; endif;?> placeholder="Perera"
                           value="<?php echo $userInfo['lName']; ?>" />
                    <?php if (isset($error['lname'])) : echo '<label class="invalid-feedback">'.$error['lname'].'</label>'; endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label>Display name</label>
                <input type="text" name="dispName" class="form-control <?php if (isset($error['dispName'])) : echo "is-invalid"; endif; ?>"
                    <?php if (isset($_POST['dispName'])): echo 'value="'.$_POST['dispName'].'"'; endif; ?> placeholder="Saman"
                       value="<?php echo $userInfo['dispName']; ?>" />
                <?php if (isset($error['dispName'])) : echo '<label class="invalid-feedback">'.$error['dispName'].'</label>'; endif; ?>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control <?php if (isset($error['address'])) : echo "is-invalid"; endif; ?>"
                    <?php if (isset($_POST['address'])): echo 'value="'.$_POST['address'].'"'; endif; ?> placeholder="No.15, Main Street Colombo 05"
                       value="<?php echo $userInfo['addr']; ?>" />
                <?php if (isset($error['address'])) : echo '<label class="invalid-feedback">'.$error['address'].'</label>'; endif; ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>NIC number</label>
                    <input type="text" name="nic" class="form-control <?php if (isset($error['nic'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['nic'])): echo 'value="'.$_POST['nic'].'"'; endif; ?> placeholder="123456789V"
                           value="<?php echo $userInfo['nic']; ?>" />
                    <?php if (isset($error['nic'])) : echo '<label class="invalid-feedback">'.$error['nic'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone number</label>
                    <input type="number" name="mNumber" class="form-control <?php if (isset($error['mNumber'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['mNumber'])): echo 'value="'.$_POST['mNumber'].'"'; endif; ?> placeholder="0112548798"
                           value="<?php echo $userInfo['telNum']; ?>" />
                    <?php if (isset($error['mNumber'])) : echo '<label class="invalid-feedback">'.$error['mNumber'].'</label>'; endif; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo $userInfo['email']; ?>" disabled />
                </div>
            </div>
            <input type="submit" class="btn btn-success" name="update" value="Update">
        </form>
    </div>

<?php include('../main/ui-footer.php'); ?>
<?php
include('../../content/function.php');

$error = array();

if (isset($_POST['submit'])) {

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

    $email = check_input($_POST['email']);
    $confirmEmail = check_input($_POST['confirmEmail']);

    if (empty($_POST["email"])) {
        $error['email'] = "Enter email";
    } else {
        if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email is invalid";
        } elseif (check_duplicate_email($email)) {
            $error['email'] = "Email is Duplicate";
        }
    }

    if (empty($_POST["confirmEmail"])) {
        $error['confirmEmail'] = "Enter email";
    } else {
        if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
            $error['confirmEmail'] = "Email is invalid";
        }
    }

    if (!isset($error['email']) && !isset($error['confirmEmail'])) {
        if ($email !== $confirmEmail) {
            $error['confirmEmailState'] = "Email not match";
        }
    }

    $errorCount = count($error);

    if (0 === $errorCount) {
        $password = random_number();
        $passwordMD5 = md5($password);

        $userRegQuery = "INSERT INTO `users`(`fName`, `lName`, `dispName`, `addr`, `telNum`, `nic`, `email`, `password`, `proImg`, `status`)
                        VALUES('$firstName', '$lastName', '$disName', '$address', '$mNumber', '$nic', '$email', '$passwordMD5', 'default.png', '1');";

        if (mysqli_query($conn, $userRegQuery)) {
//            sendMail($email,"New account password",$password);

            $dbQuery = "SELECT `userId` FROM `users` WHERE `email` = '" . $email . "';";
            $dbResult = mysqli_query($conn, $dbQuery);
            $row = mysqli_fetch_assoc($dbResult);
            header('Location: user-view.php?uid='.$row['userId'].'&type=view');
            exit();
        }
    }
}

function check_duplicate_nic($nic)
{
    global $conn;
    $dbQuery = "SELECT `userId` FROM `users` WHERE `nic` = '" . $nic . "';";
    $dbResult = mysqli_query($conn, $dbQuery);
    if ($dbResult && mysqli_num_rows($dbResult) == 1) {
        return true;
    } else {
        return false;
    }
}

function check_duplicate_email($email)
{
    global $conn;
    $dbQuery = "SELECT `userId` FROM `users` WHERE `email` = '" . $email . "';";
    $dbResult = mysqli_query($conn, $dbQuery);
    if ($dbResult && mysqli_num_rows($dbResult) == 1) {
        return true;
    } else {
        return false;
    }
}
?>

<?php include('../main/ui-head.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <h3 class="display-4 h6">Create Account</h3>
            <h3 class="display-4 h6">Get your access today in one easy step</h3>
         
        </div>
        <form method="post" action="user-registration.php" class="mt-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First name</label>
                    <input type="text" name="fname" class="form-control <?php if (isset($error['fname'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['fname'])): echo 'value="'.$_POST['fname'].'"'; endif; ?> placeholder="Saman">
                    <?php if (isset($error['fname'])) : echo '<label class="invalid-feedback">'.$error['fname'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Last name</label>
                    <input type="text" name="lname" class="form-control <?php if (isset($error['lname'])) : echo "is-invalid"; endif; ?>"
                        <?php if (isset($_POST['fname'])): echo 'value="'.$_POST['fname'].'"'; endif;?> placeholder="Perera">
                    <?php if (isset($error['lname'])) : echo '<label class="invalid-feedback">'.$error['lname'].'</label>'; endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label>Display name</label>
                <input type="text" name="dispName" class="form-control <?php if (isset($error['dispName'])) : echo "is-invalid"; endif; ?>"
                    <?php if (isset($_POST['dispName'])): echo 'value="'.$_POST['dispName'].'"'; endif; ?> placeholder="Saman">
                <?php if (isset($error['dispName'])) : echo '<label class="invalid-feedback">'.$error['dispName'].'</label>'; endif; ?>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control <?php if (isset($error['address'])) : echo "is-invalid"; endif; ?>"
                       <?php if (isset($_POST['address'])): echo 'value="'.$_POST['address'].'"'; endif; ?> placeholder="No.15, Mainstreet, Colombo 05">
                <?php if (isset($error['address'])) : echo '<label class="invalid-feedback">'.$error['address'].'</label>'; endif; ?>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>NIC number</label>
                    <input type="text" name="nic" class="form-control <?php if (isset($error['nic'])) : echo "is-invalid"; endif; ?>"
                           <?php if (isset($_POST['nic'])): echo 'value="'.$_POST['nic'].'"'; endif; ?> placeholder="987654321V">
                    <?php if (isset($error['nic'])) : echo '<label class="invalid-feedback">'.$error['nic'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone number</label>
                    <input type="number" name="mNumber" class="form-control <?php if (isset($error['mNumber'])) : echo "is-invalid"; endif; ?>"
                           <?php if (isset($_POST['mNumber'])): echo 'value="'.$_POST['mNumber'].'"'; endif; ?> placeholder="0112233445">
                    <?php if (isset($error['mNumber'])) : echo '<label class="invalid-feedback">'.$error['mNumber'].'</label>'; endif; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control <?php if (isset($error['email']) || isset($error['confirmEmailState'])) : echo "is-invalid"; endif; ?>"
                           placeholder="saman@gmail.com">
                    <?php if (isset($error['email'])) : echo '<label class="invalid-feedback">'.$error['email'].'</label>'; endif; ?>
                    <?php if (isset($error['confirmEmailState'])) : echo '<label class="invalid-feedback">'.$error['confirmEmailState'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Confirm email</label>
                    <input type="email" name="confirmEmail" class="form-control <?php if (isset($error['confirmEmail']) || isset($error['confirmEmailState'])) : echo "is-invalid"; endif; ?>"
                           placeholder="saman@gmail.com">
                    <?php if (isset($error['confirmEmail'])) : echo '<label class="invalid-feedback">'.$error['confirmEmail'].'</label>'; endif; ?>
                    <?php if (isset($error['confirmEmailState'])) : echo '<label class="invalid-feedback">'.$error['confirmEmailState'].'</label>'; endif; ?>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php include('../main/ui-footer.php'); ?>
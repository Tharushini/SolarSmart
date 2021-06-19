<?php
include('../main/ui-head.php');

$error = array();
$info_device = array();
$id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_POST['update']))
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    if (empty($name)) {
        $error['name'] = "Name is empty";
    }

    if (empty($desc)) {
        $error['desc'] = "desc is empty";
    }

    if (0 == count($error)) {
        $userRegQuery = "UPDATE `device` SET `name`='$name',`desc`='$desc' WHERE `id`='$id';";

        if (mysqli_query($conn, $userRegQuery)) {
        }
    }
}

$dbQuery = "SELECT * FROM `device` WHERE id='$id';";

if ($result = mysqli_query($conn, $dbQuery)) {
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $info_device['id'] = $row['id'];
        $info_device['name'] = $row['name'];
        $info_device['desc'] = $row['desc'];
        $info_device['powerState'] = $row['powerState'];
        $info_device['status'] = $row['status'];
        $info_device['regDate'] = $row['regDate'];
    }
}
?>
<div class="container mt-5">

    <div class="row">
        <h3 class="display-4 h6"><?php echo $info_device['name']; ?></h3>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Control
                </div>
                <div class="card-body p-0">
                    <div class="form-row">
                        <div class="form-group col-md-6 p-4">
                            <?php if ($info_device['powerState'] == '0'): ?>
                            <input type="button" value="Turn ON" class="btn btn-success" name="turn_on">
                            <?php else: ?>
                            <input type="button" value="Turn OFF" class="btn btn-warning" name="turn_off">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form class="mt-4" action="<?php echo WEB_URL; ?>package/device/device-view.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Device ID</label>
                <input type="text" name="id" class="form-control" value="<?php echo $info_device['id']; ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Section name</label>
                <input type="text" class="form-control <?php if (isset($error['name'])) : echo "is-invalid"; endif; ?>"
                       name="name" value="<?php echo $info_device['name']; ?>">
                <?php if (isset($error['name'])) : echo '<label class="invalid-feedback">'.$error['name'].'</label>'; endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label>Section description</label>
                <textarea type="text" name="desc" class="form-control <?php if (isset($error['desc'])) : echo "is-invalid"; endif; ?>"><?php echo $info_device['desc']; ?></textarea>
                <?php if (isset($error['desc'])) : echo '<label class="invalid-feedback">'.$error['desc'].'</label>'; endif; ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Date</label>
                <input type="text" class="form-control" value="<?php echo $info_device['regDate']; ?>" disabled>
            </div>
        </div>
        <input name="update" type="submit" value="Update" class="btn btn-primary">
    </form>
</div>
<?php include('../main/ui-footer.php'); ?>

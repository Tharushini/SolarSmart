<?php
include('../main/ui-head.php');

$error = array();
$info_section = array();
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
        $userRegQuery = "UPDATE `section` SET `name`='$name',`desc`='$desc' WHERE `id`='$id';";

        if (mysqli_query($conn, $userRegQuery)) {
        }
    }
}

$dbQuery = "SELECT * FROM `section` WHERE id='$id';";

if ($result = mysqli_query($conn, $dbQuery)) {
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $info_section['id'] = $row['id'];
        $info_section['name'] = $row['name'];
        $info_section['desc'] = $row['desc'];
        $info_section['status'] = $row['status'];
        $info_section['regDate'] = $row['regDate'];
    }
}
?>
<div class="container mt-5">

    <div class="row">
        <h3 class="display-4 h6"><?php echo $info_section['name']; ?></h3>
    </div>

    <form class="mt-4" action="<?php echo WEB_URL; ?>package/section/section-view.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Section ID</label>
                <input type="text" name="id" class="form-control" value="<?php echo $info_section['id']; ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Section name</label>
                <input type="text" class="form-control <?php if (isset($error['name'])) : echo "is-invalid"; endif; ?>"
                       name="name" value="<?php echo $info_section['name']; ?>">
                <?php if (isset($error['name'])) : echo '<label class="invalid-feedback">'.$error['name'].'</label>'; endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label>Section description</label>
                <textarea type="text" name="desc" class="form-control <?php if (isset($error['desc'])) : echo "is-invalid"; endif; ?>"><?php echo $info_section['desc']; ?></textarea>
                <?php if (isset($error['desc'])) : echo '<label class="invalid-feedback">'.$error['desc'].'</label>'; endif; ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Date</label>
                <input type="text" class="form-control" value="<?php echo $info_section['regDate']; ?>" disabled>
            </div>
        </div>
        <input name="update" type="submit" value="Update" class="btn btn-primary">
    </form>
</div>
<?php include('../main/ui-footer.php'); ?>

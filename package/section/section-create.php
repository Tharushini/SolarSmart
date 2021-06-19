<?php
include('../main/ui-head.php');

$error = array();

if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $desc = $_POST['desc'];

    if (empty($name)) {
        $error['name'] = "Name is empty";
    }

    if (empty($desc)) {
        $error['desc'] = "desc is empty";
    }

    if (0 == count($error)) {
        $query = "INSERT INTO `section`(`name`, `desc`, `status`) VALUES ('$name','$desc','1')";

        if (mysqli_query($conn, $query)) {
            header('Location: section-list.php');
            exit();
        }
    }
}

?>
    <div class="container mt-5">

        <div class="row">
            <h3 class="display-4 h6">Section create</h3>
        </div>

        <form class="mt-4" method="post" action="section-create.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Section name</label>
                    <input type="text" class="form-control <?php if (isset($error['name'])) : echo "is-invalid"; endif; ?>" name="name" placeholder="Device 1">
                    <?php if (isset($error['name'])) : echo '<label class="invalid-feedback">'.$error['name'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Section description</label>
                    <textarea type="text" class="form-control <?php if (isset($error['desc'])) : echo "is-invalid"; endif; ?>" name="desc" placeholder="Example"></textarea>
                    <?php if (isset($error['desc'])) : echo '<label class="invalid-feedback">'.$error['desc'].'</label>'; endif; ?>
                </div>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Create</button>
        </form>
    </div>
<?php include('../main/ui-footer.php'); ?>

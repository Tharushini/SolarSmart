<?php
include('../main/ui-head.php');

$section_list = get_section_list();

function get_section_list(){
    global $conn;
    $info_section = array();
    $dbQuery = "SELECT * FROM `section`;";
    if ($result = mysqli_query($conn, $dbQuery)) {
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = array();
                $data['id'] = $row['id'];
                $data['name'] = $row['name'];
                array_push($info_section, $data);
            }
        }
    }
    return $info_section;
}


$error = array();
if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $sid = $_POST['section_id'];

    if (empty($name)) {
        $error['name'] = "Name is empty";
    }

    if (empty($desc)) {
        $error['desc'] = "desc is empty";
    }

    if ($sid == "none") {
        $error['sid'] = "select section";
    }

    if (0 == count($error)) {
        $query = "INSERT INTO `device`(`name`, `sid`, `desc`, `status`, `powerState`) VALUES ('$name','$sid','$desc','1','0')";

        if (mysqli_query($conn, $query)) {
            header('Location: device-list.php');
            exit();
        }
    }
}

?>
    <div class="container mt-5">

        <div class="row">
            <h3 class="display-4 h6">Device create</h3>
        </div>

        <form class="mt-4" method="post" action="device-create.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Device name</label>
                    <input type="text" class="form-control <?php if (isset($error['name'])) : echo "is-invalid"; endif; ?>" name="name" placeholder="Device 1">
                    <?php if (isset($error['name'])) : echo '<label class="invalid-feedback">'.$error['name'].'</label>'; endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Device description</label>
                    <textarea type="text" class="form-control <?php if (isset($error['desc'])) : echo "is-invalid"; endif; ?>" name="desc" placeholder="Example"></textarea>
                    <?php if (isset($error['desc'])) : echo '<label class="invalid-feedback">'.$error['desc'].'</label>'; endif; ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Device</label>
                    <select name="section_id" class="custom-select mr-sm-2">
                        <option selected value="none">Choose</option>
                        <?php for ($i = 0; count($section_list) > $i; $i++): ?>
                            <option value="<?php echo $section_list[$i]['id'] ;?>"><?php echo $section_list[$i]['name']; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Create</button>
        </form>
    </div>
<?php include('../main/ui-footer.php'); ?>

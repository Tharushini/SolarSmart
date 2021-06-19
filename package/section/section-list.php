<?php include('../main/ui-head.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <h3 class="display-4 h6">Section List</h3>
        </div>

        <div class="row mt-4">

            <div class="bg-light col-12 pt-3 pb-2 pr-3 pl-3">
                <a href="section-create.php" class="btn btn-primary mb-2">Section Create</a>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Device name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $dbQuery = "SELECT * FROM `section`;";
                if ($result = mysqli_query($conn, $dbQuery)):
                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):?>
                            <tr>
                                <th scope="row"><?php echo $row['id']; ?></th>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['regDate']; ?></td>
                                <td><?php if ($row['status'] == 1) { echo "Active"; } else { echo "Inactive"; } ?></td>
                                <td><a href="<?php echo WEB_URL; ?>package/section/section-view.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary">View</a></td>
                            </tr>
                        <?php endwhile; endif; endif;?>
                </tbody>
            </table>
        </div>
    </div>

<?php include('../main/ui-footer.php'); ?>
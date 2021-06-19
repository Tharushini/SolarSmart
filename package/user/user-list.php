<?php
include('../main/ui-head.php');
?>

    <div class="container mt-5">
        <div class="row">
            <h3 class="display-4 h6">User List</h3>
        </div>

        <div class="row mt-4">

            <div class="bg-light col-12 pt-3 pb-2 pr-3 pl-3">
                <a href="user-registration.php" class="btn btn-primary mb-2">User Create</a>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Display name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $dbQuery = "SELECT `userId`,`dispName`,`email`,`status`,`regDate` FROM `users` WHERE userId != '1';";

                if ($result = mysqli_query($conn, $dbQuery)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                            <td>'.$row['userId'].'</td>
                            <td>'.$row['dispName'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['status'].'</td>
                            <td>'.$row['regDate'].'</td>
                            <td><a  class="btn btn-outline-info" href="user-view.php?uid='.$row['userId'].'&type=view">View</a></td>
                            </tr>';
                        }
                    } else {
                        echo '
                        <tr>
                            <th scope="row">No recode</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include('../main/ui-footer.php'); ?>
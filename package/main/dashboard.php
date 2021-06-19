<?php
include('ui-head.php');

$turn_on_device = turn_on_device();
$all_device = all_devices();

function turn_on_device() {
    global $conn;
    $query = "SELECT `section`.name AS sn,device.name AS dn FROM device JOIN `section` ON device.sid = `section`.id WHERE device.powerState='1';";
    $recodes = array();
    if ($result = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recodes[] = $row;
            }
        }
    }

    return json_encode(array_map('array_values', $recodes));
}

function all_devices() {
    global $conn;
    $query = "SELECT `section`.name AS sn,device.name AS dn, device.powerState AS ps FROM device JOIN `section` ON device.sid = `section`.id;";
    $recodes = array();
    if ($result = mysqli_query($conn, $query)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recodes[] = $row;
            }
        }
    }

    return json_encode(array_map('array_values', $recodes));
}
?>
    <div class="container">

        <div class="row mt-4">
            <div class="col-sm-6 mb-2">
                <div class="card">
                    <div class="card-header">
                        Turn On Devices
                    </div>
                    <div class="card-body">
                        <script>
                            var dataset = <?php echo $turn_on_device; ?>;

                            $(document).ready(function() {
                                $('#example5').DataTable( {
                                    data: dataset,
                                    columns: [
                                        { title: "Section name" },
                                        { title: "Device name" }
                                    ]
                                } );
                            });
                        </script>
                        <table id="example5" class="display" width="100%"></table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-2">
                <div class="card">
                    <div class="card-header">
                        All Devices
                    </div>
                    <div class="card-body">
                        <script>
                            var datasets = <?php echo $all_device; ?>;

                            $(document).ready(function() {
                                $('#example').DataTable( {
                                    data: datasets,
                                    columns: [
                                        { title: "Section name" },
                                        { title: "Device name" },
                                        { title: "Power State" }
                                    ]
                                } );
                            });
                        </script>
                        <table id="example" class="display" width="100%"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('ui-footer.php'); ?>
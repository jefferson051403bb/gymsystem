<?php
    // Database connection
    $hname = 'localhost';
    $uname = 'root';
    $pass = '';
    $db = 'gymko';

    $con = mysqli_connect($hname, $uname, $pass, $db);

    if(!$con) {
        die("Cannot connect to database: " . mysqli_connect_error());
    }

    // Fetch attendance data from the database
    $query = "SELECT * FROM attendance LEFT JOIN user_cred ON user_cred.user_id = attendance.user_id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <?php require('inc/links.php');?>

</head>
<body class="bg-light">
    
    <?php require('inc/header.php');?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Invoices</h3>

                        <div class="text-end mb-4">
                            <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search...">
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border" id="gymTable">
                                <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <th scope="row"><?= htmlspecialchars($row["attendance_id"]) ?></th>
                                        <td><?= htmlspecialchars($row["name"]) ?></td>
                                        <td><?= htmlspecialchars($row["address"]) ?></td>
                                        <td><?= htmlspecialchars($row["time_in"]) ?></td>
                                        <td><?= htmlspecialchars($row["time_out"]) ?></td>
                                        <td>
                                            <div class="action-button">
                                                <button class="btn btn-danger delete-button" onclick="deleteAttendance(<?= htmlspecialchars($row["attendance_id"]) ?>)">X</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

  

    <?php require('inc/scripts.php');?>
</body>
</html>

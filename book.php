<?php

require('inc/links.php');

$mysqli = new mysqli('localhost', 'root', '', 'gymko');

// Check if user is logged in and session variables are set
if (!isset($_SESSION['uId'])) {
    die("User not logged in");
}

// Check user's appointment status
$user_id = $_SESSION['uId'];
$statusStmt = $mysqli->prepare("SELECT appointment_status FROM user_cred WHERE user_id = ?");
$statusStmt->bind_param('i', $user_id);
$statusStmt->execute();
$statusResult = $statusStmt->get_result();
$userStatus = $statusResult->fetch_assoc();
$statusStmt->close();

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("SELECT * FROM bookings WHERE date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['timeslot'];
            }
            $stmt->close();
        }
    }
}

$updateStmt = null;

if (isset($_POST['submit']) && $userStatus['appointment_status'] != 'pending' && $userStatus['appointment_status'] != 'approved') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenum = $_POST['phonenum'];
    $note = $_POST['note'];
    $trainor_name = $_POST['trainor_name'];
    $timeslot = $_POST['timeslot'];
    $stmt = $mysqli->prepare("SELECT * FROM bookings WHERE date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $timeslot);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Slot is already booked
        } else {
            $stmt = $mysqli->prepare("INSERT INTO bookings (user_id, name, timeslot, email, phonenum, note, date, trainor_name) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssss', $user_id, $name, $timeslot, $email, $phonenum, $note, $date, $trainor_name);
            $stmt->execute();

            // Update appointment status in user_cred table to pending
            $updateStmt = $mysqli->prepare("UPDATE user_cred SET appointment_status = 'pending' WHERE user_id = ?");
            if ($updateStmt) {
                $updateStmt->bind_param('i', $_SESSION['uId']);
                $updateStmt->execute();
                $updateStmt->close();
            } else {
                echo "Prepare failed: " . $mysqli->error;
            }

            $msg = "<div class='alert alert-success'>Appointment Submitted!</div>";
            $bookings[] = $timeslot;
            $mysqli->close();
        }
    }
}

$duration = 30;
$cleanup = 0;
$start = "7:00";
$end = "18:00";

function timeslots($duration, $cleanup, $start, $end) {
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA")."-".$endPeriod->format("H:iA");
    }

    return $slots;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Appointment</title>
    
    <link rel="stylesheet" href="css/common.css">

    <style>

        .btn{
            background-color: #09858d !important;
            color: white !important;
        }

        .btn:hover{
            background-color: #096066 !important;
        }

        .btn1{
            border: 1px solid #09858d !important;
            color: #09858d !important;
            text-decoration: none !important;
        }

        .btn1:hover{
            background-color: #096066 !important;
            color: white !important;
        }
        
    </style>

</head>
<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container">
        <div class="row d-flex justify-content-center bg-light shadow mt-5 rounded mb-3 p-2">
            <div class="mt-4">
                <h2 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h2>
            </div>
            <div class="col-md-12">
                <?php echo isset($msg) ? $msg : ""; ?>
            </div>
            <div class="mb-2" style="font-size: 14px; margin-left: 15px;">
            <a href="#" onclick="goBack()" class="text-secondary text-decoration-none"> < BACK</a>
            </div>
            <hr style="width: 98%;">
            <?php if ($userStatus['appointment_status'] == 'pending') { ?>
                <div class="alert alert-warning" style="height: 150px;">You already have a pending appointment. Please complete or cancel your current appointment before booking a new one.</div>
                <br><br><br>
            <?php } elseif ($userStatus['appointment_status'] == 'approved') { ?>
                <div class="alert alert-warning" style="height: 150px;">You already have an appointment. Please complete or cancel your current appointment before booking a new one.</div>
                <br><br><br>
            <?php } else { ?>
                <?php
                $timeslots = timeslots($duration, $cleanup, $start, $end);
                foreach ($timeslots as $ts) { ?>
                    <div class="col-md-2 p-2">
                        <div class="form-group">
                            <?php if (in_array($ts, $bookings)) { ?>
                                <button class="btn m-1 p-2 appoint unavailable haber" style="width: 170px; background-color: #dc3545 !important;" disabled><?php echo $ts; ?></button>
                            <?php } else { ?>
                                <button class="btn m-1 p-2 appoint" style="width: 170px;" data-bs-toggle="modal" data-bs-target="#myModal" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <br><br><br><br>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Appointment: <span id="slot"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="">Timeslot</label>
                            <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Trainor</label>
                            <input required type="text" readonly name="trainor_name" id="trainor_name" class="form-control" value="<?php echo isset($_SESSION['trainor']['name']) ? $_SESSION['trainor']['name'] : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">ID</label>
                            <input required type="text" readonly name="user_id" id="user_id" class="form-control" value="<?php echo isset($_SESSION['uId']) ? $_SESSION['uId'] : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input required type="text" name="name" id="username" class="form-control" value="<?php echo isset($_SESSION['uName']) ? $_SESSION['uName'] : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input required type="email" name="email" class="form-control" value="<?php echo isset($_SESSION['uEmail']) ? $_SESSION['uEmail'] : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Phone no.</label>
                            <input required type="number" name="phonenum" class="form-control" value="<?php echo isset($_SESSION['uPhone']) ? $_SESSION['uPhone'] : ''; ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Note (optional)</label>
                            <textarea name="note" class="form-control shadow-none" rows="3"></textarea>
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn custom-bg text-white" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".appoint").click(function() {
                var timeslot = $(this).data('timeslot');
                $("#slot").html(timeslot);
                $("#timeslot").val(timeslot);
                $("#myModal").modal("show");
            });
        });
    </script>
    <script>
    function goBack() {
        var trainor_id = <?php echo isset($_SESSION['trainor']['trainor_id']) ? $_SESSION['trainor']['trainor_id'] : 'null'; ?>;
        if (trainor_id) {
            window.location.href = 'confirm_app.php?trainor_id=' + trainor_id;
        } else {
            window.location.href = 'trainors.php';
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-Ksv66P63K9Z6ldo05Hi7gdOKhbCTErzBHI7JX9C8WjKw5H9AAKDF9Iqz2dt9RlEW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGhai24PBWxT6EM2H7K4kO5v3Y3pvK2r0zKTZLIFl9v8BSsRy7AYjqQauC" crossorigin="anonymous"></script>
</body>
</html>

<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['qr_code'])) {
        $qrCode = $_POST['qr_code'];

        $selectStmt = $conn->prepare("SELECT user_id FROM user_cred WHERE qr_code = :qr_code");
        $selectStmt->bindParam(":qr_code", $qrCode, PDO::PARAM_STR);

        if ($selectStmt->execute()) {
            $result = $selectStmt->fetch();
            if ($result !== false) {
                $user_id = $result["user_id"];
                $timeIn = date("Y-m-d H:i:s");
                $timeout = $timeIn; // Set time_out to the same as time_in for now

                try {
                    $stmt = $conn->prepare("INSERT INTO attendance (user_id, time_in, time_out) VALUES (:user_id, :time_in, :time_out)");
                    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
                    $stmt->bindParam(":time_in", $timeIn, PDO::PARAM_STR);
                    $stmt->bindParam(":time_out", $timeout, PDO::PARAM_STR);

                    $stmt->execute();

                    header("Location: http://localhost/GYMKO/admin/attendance.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "No user found with this QR Code";
            }
        } else {
            echo "Failed to execute the statement.";
        }
    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/GYMKO/admin/attendance.php';
            </script>
        ";
    }
}
?>

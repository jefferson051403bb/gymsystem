<?php
   require('../inc/db_config.php');
   require('../inc/essentials.php');
   adminLogin();

if (isset($_GET['attendance'])) {
    $attendance = $_GET['attendance'];

    try {

        $query = "DELETE FROM attendance WHERE attendance_id = '$attendance'";

        $stmt = $conn->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Attendance deleted successfully!');
                    window.location.href = 'http://localhost/gymko/attendance.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete attendance!');
                    window.location.href = 'http://localhost/gymko/attendance.php';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
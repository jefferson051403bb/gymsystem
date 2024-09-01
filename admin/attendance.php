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
    <title>QR Code Attendance System</title>

    <style>
        #interactive {
            border: 1px solid #ddd;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            display: block;
            object-fit: cover; /* Maintain aspect ratio while covering the entire area */
        }

        .scanner-con {
            width: 100%;
            max-width: 500px; /* Set a max width for the scanner container */
            margin: 0 auto; /* Center the container */
            position: relative; /* Position relative for absolute positioning within */
        }

        .video-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .scanner-area {
            border: 2px dashed #0d6efd;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background-color:white;
            top: 0;
            left: 0;
            animation: scan 3s linear infinite;
            z-index: 10;
        }

        @keyframes scan {
            0% {
                top: 0;
            }
            50% {
                top: 100%;
            }
            100% {
                top: 0;
            }
        }

        .qr-detected-container {
            display: none; /* Hidden by default */
        }
        
    </style>
    <?php require('inc/links.php');?>

</head>
<body class="bg-light">
    
    <?php require('inc/header.php');?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Attendance</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="scanner-con">
                            <h5 class="text-center">Scan your QR Code here for your attendance</h5>
                            <div class="video-container">
                                <video id="interactive" autoplay playsinline></video>
                                <div class="overlay">
                                    <div class="scanner-area">
                                        <div class="scan-line"></div> <!-- Scanning line -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mb-4">
                            <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search...">
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border" id="gymTable">
                                <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Time In</th>
                                    <th scope="col">Time Out</th>
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

    <!-- Instascan JS -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    
    <script>
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content, decodedQrCode) {
                console.log('QR Code Content:', content); // Debugging output
                console.log('Decoded QR Code Object:', decodedQrCode); // Debugging output
                
                // If QR code detected, update its content
                document.getElementById("detected-qr-code").value = content;

                // Extract position information if available
                if (decodedQrCode) {
                    updateScannerArea(decodedQrCode);
                } else {
                    console.error('No QR code data received.');
                }

                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-con").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                        console.log('Camera started.');
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        function updateScannerArea(decodedQrCode) {
            // Check if decodedQrCode contains position data
            if (decodedQrCode && decodedQrCode.hasOwnProperty('x') && decodedQrCode.hasOwnProperty('y')) {
                const video = document.getElementById('interactive');
                const videoWidth = video.videoWidth;
                const videoHeight = video.videoHeight;

                const x = decodedQrCode.x * videoWidth;
                const y = decodedQrCode.y * videoHeight;
                const width = decodedQrCode.width * videoWidth;
                const height = decodedQrCode.height * videoHeight;

                const scannerArea = document.querySelector('.scanner-area');
                scannerArea.style.left = `${x}px`;
                scannerArea.style.top = `${y}px`;
                scannerArea.style.width = `${width}px`;
                scannerArea.style.height = `${height}px`;
            } else {
                console.error('QR Code position data is missing.');
            }
        }

        document.addEventListener('DOMContentLoaded', startScanner);
    </script>

    <?php require('inc/scripts.php');?>
</body>
</html>

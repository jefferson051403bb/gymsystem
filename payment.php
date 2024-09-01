<?php
// GCash API keys
$publishableKey = "pk_test_meHnzfnwJXbyd2BYoiVPlK";
$secretKey = "sk_test_AjOXVX5ZHraQfSid1uXDsI";

// Start a session to store the OTP
session_start();

// Function to send OTP using Infobip
function sendOtp($gcashNumber) {
    if (empty($gcashNumber)) {
        echo "GCash number is empty.<br>";
        return false;
    }

    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    $_SESSION['otp'] = $otp; // Save OTP in session

    $apiUrl = 'https://ggnm6r.api.infobip.com/sms/2/text/advanced'; 
    $apiKey = 'facb73c3f246f0e21135f88219bfedf2-38c7d6e3-6fad-4a61-9769-3b66f637acbf'; // Replace with your Infobip API key

    $message = "Your OTP is: $otp";

    $data = [
        'messages' => [
            [
                'from' => 'Gea FITNESS GYM',
                'destinations' => [
                    [
                        'to' => $gcashNumber
                    ]
                ],
                'text' => $message
            ]
        ]
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: App $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    if ($httpCode == 200) {
        return true; // OTP sent successfully
    } else {
        echo "Failed to send OTP. HTTP Status Code: $httpCode<br>";
        echo "Response: $response"; // Debugging response
        return false;
    }
}

// Check if the form was submitted for OTP verification
if (isset($_POST['verify_otp'])) {
    $userOtp = $_POST['otp'];
    
    // Verify the OTP
    if ($userOtp == $_SESSION['otp']) {
        // OTP is correct, proceed with the payment process
        $amount = $_SESSION['amount'];
        $gcashNumber = $_SESSION['gcashNumber'];

        // Step 1: Create a GCash source
        $sourceUrl = "https://api.magpie.im/v1.1/sources";
        $sourceData = [
            "currency" => "PHP",
            "type" => "gcash",
            "redirect" => [
                "success" => "https://magpie.im?status=success",
                "fail" => "https://magpie.im?status=fail"
            ]
        ];

        $ch = curl_init($sourceUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $secretKey",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sourceData));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            exit;
        }

        curl_close($ch);
        $sourceResponse = json_decode($response, true);

        // Debug output for source response
        echo '<h3>Source Response:</h3>';
        echo '<pre>';
        print_r($sourceResponse);
        echo '</pre>';

        // Check for HTTP response code and source creation
        if ($httpCode !== 200) {
            echo "Failed to create GCash source. HTTP Status Code: $httpCode<br>";
            if (isset($sourceResponse['message'])) {
                echo "Error Message: " . $sourceResponse['message'];
            }
            exit;
        }

        if (isset($sourceResponse['id'])) {
            $sourceId = $sourceResponse['id'];

            // Step 2: Create a charge using the source
            $chargeUrl = "https://api.magpie.im/v1.1/charges";
            $chargeData = [
                "amount" => $amount * 100, // Convert to cents
                "currency" => "PHP",
                "source" => $sourceId,
                "description" => "GCash charge",
                "statement_descriptor" => "merchant.com",
                "capture" => true
            ];

            $ch = curl_init($chargeUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $secretKey",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($chargeData));
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
                exit;
            }

            curl_close($ch);
            $chargeResponse = json_decode($response, true);

            // Debug output for charge response
            echo '<h3>Charge Response:</h3>';
            echo '<pre>';
            print_r($chargeResponse);
            echo '</pre>';

            // Check for HTTP response code and charge creation
            if ($httpCode !== 200) {
                echo "Failed to create GCash charge. HTTP Status Code: $httpCode<br>";
                if (isset($chargeResponse['message'])) {
                    echo "Error Message: " . $chargeResponse['message'];
                }
                exit;
            }

            if (isset($chargeResponse['status']) && $chargeResponse['status'] === 'pending') {
                // Redirect user to GCash payment page
                header("Location: " . $chargeResponse['checkout_url']);
                exit;
            } else {
                echo "Payment failed: " . (isset($chargeResponse['status']) ? $chargeResponse['status'] : 'Unknown error');
            }
        } else {
            echo "Failed to create GCash source.";
        }
    } else {
        echo "Invalid OTP.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gcashNumber'])) {
    // Store the amount and GCash number in session
    $_SESSION['amount'] = $_POST['amount'];
    $_SESSION['gcashNumber'] = $_POST['gcashNumber'];

    // Debugging: Check the value of gcashNumber
    echo "GCash Number: " . htmlspecialchars($_POST['gcashNumber']) . "<br>";

    // Step 2: Send OTP to GCash number
    if (sendOtp($_POST['gcashNumber'])) {
        // Show OTP verification form
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Verify OTP</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #21364b;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 60vh;
                    margin: 0;
                }
                .otp-container {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    width: 100%;
                    text-align: center;
                }
                .form-group {
                    margin-bottom: 15px;
                }
                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                    color: #21364b;
                }
                .form-group input {
                    width: 100%;
                    padding: 10px;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                    font-size: 16px;
                    background-color: #f7f9fc;
                    color: #21364b;
                    box-sizing: border-box;
                }
                .form-group button {
                    width: 100%;
                    padding: 10px;
                    background-color: #21364b;
                    border: none;
                    border-radius: 5px;
                    color: white;
                    font-size: 18px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }
                .form-group button:hover {
                    background-color: #16293b;
                }
            </style>
        </head>
        <body>
            <div class="otp-container">
                <h2>Verify OTP</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" value"63" name="otp" placeholder="Enter the OTP sent to your GCash number" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="verify_otp">Verify OTP</button>
                    </div>
                </form>
            </div>
        </body>
        </html>';
    } else {
        echo "Failed to send OTP.";
    }
} else {

    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GEA Fitness Gym Payment</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #21364b;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .gcash-container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                width: 100%;
                text-align: center;
            }
            .gym-logo {
                font-size: 28px;
                font-weight: bold;
                color: #21364b;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #21364b;
            }
            .form-group input {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 16px;
                background-color: #f7f9fc;
                color: #21364b;
                box-sizing: border-box;
            }
            .form-group input::placeholder {
                color: #a3aab2;
            }
            .form-group button {
                width: 100%;
                padding: 10px;
                background-color: #21364b;
                border: none;
                border-radius: 5px;
                color: white;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .form-group button:hover {
                background-color: #16293b;
            }
        </style>
    </head>
    <body>
        <div class="gcash-container">
            <div class="gym-logo">GEA Fitness Gym</div>
            <h2>Pay with GCash</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="gcashNumber">GCash Number</label>
                    <input type="text" id="gcashNumber" name="gcashNumber" placeholder="Enter your GCash number" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount (PHP)</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="pay">Pay Now</button>
                </div>
            </form>
        </div>
    </body>
    </html>';
}
?>

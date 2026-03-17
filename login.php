<?php
// login.php
session_start();
include 'db.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $mpin = $_POST['mpin'];

    // Prepare SQL to fetch user
    $stmt = $conn->prepare("SELECT id, fullname, mpin_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $mpin_hash);
        $stmt->fetch();

        // Verify MPIN
        if(password_verify($mpin, $mpin_hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            echo "<p style='color:green; text-align:center;'>Login successful! Welcome, $fullname</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Invalid MPIN.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>No user found with that email.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
<h2>Login</h2>
<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="mpin" placeholder="MPIN" required>
    <input type="submit" name="login" value="Login">
</form>
<p style="text-align:center;">Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
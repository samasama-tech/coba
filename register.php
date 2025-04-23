<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form action="process_register.php" method="POST" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Phone Number: <input type="text" name="phone" required><br><br>
        Address: <input type="text" name="address" required><br><br>
        Pincode: <input type="text" name="pincode" required><br><br>
        Date of Birth: <input type="date" name="dob" required><br><br>
        Picture: <input type="file" name="picture" accept="image/*"><br><br>
        Password: <input type="password" name="password" required><br><br>
        Confirm Password: <input type="password" name="confirm_password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
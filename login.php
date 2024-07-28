<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Hash the password for comparison
        $hashed_password = md5($password); // Note: md5 is not secure, consider using a better hashing algorithm like bcrypt

        // Perform a database query to check if the user exists
        // Replace this with your actual database query
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
        // Execute the query and check if there is a matching user
        // If a user is found, log them in and start a session
        // If no user is found, display an error message
    } else {
        // Display an error message if email or password is empty
        echo "Please enter both email and password.";
    }
}

?>
<form method="post" action="login.php">
    <div class="form-group">
        <input type="email" class="form-control border-0 p-4" name="email" placeholder="Your email" required="required" />
    </div>
    <div class="form-group">
        <input type="password" class="form-control border-0 p-4" name="password" placeholder="Your password" required="required" />
    </div>
    <div>
        <button class="btn btn-dark btn-block border-0 py-3" type="submit">Sign In</button>
    </div>
</form>

<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the email and password are correct (you should validate these against your database)
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Assuming the email and password are correct
    // Redirect to your website's main page
    header("Location: index.php");
    exit(); // Ensure that no other code is executed after the redirect
}
?>
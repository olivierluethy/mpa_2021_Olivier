<?php
// Initialize the session
session_start();
session_destroy();
session_start();
$_SESSION['email'] = "";

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /rechnungen/uebersicht");
    exit;
}

// Include config file
require_once "config.php";

$password_err = $email_err ="";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;
    /* Serverside Validation */
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = true;
    }
    else {
        $isValid = false;
        $email_err = "Please enter a valid email.";
    }

    // Validate credentials
    if ($isValid) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to index page
                            header("location: uebersicht");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}

$pageTitle = 'Login';
require __DIR__ . '/partials/head.php';
?>

<div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-neutral-900 via-neutral-900 to-neutral-800 px-4">
    <div class="w-full max-w-sm rounded-2xl border border-neutral-700 bg-neutral-800 p-8 shadow-2xl shadow-black/40">
        <div class="mb-6 flex flex-col items-center gap-3 text-center">
            <img src="/images/icon.png" alt="" class="h-14 w-14 object-contain">
            <h1 class="text-2xl font-semibold text-neutral-100">Anmelden</h1>
            <p class="text-sm text-neutral-400">Bitte geben Sie Ihre Anmeldedaten ein, um sich einzuloggen.</p>
        </div>

        <form action="login" method="post" class="space-y-5">
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-neutral-300">E-Mail</label>
                <input type="text" name="email" id="email" autocomplete="username"
                       class="w-full rounded-lg border border-neutral-600 bg-neutral-900 px-3 py-2.5 text-neutral-100 placeholder-neutral-500 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/40">
                <?php if ($email_err): ?>
                    <p class="mt-1.5 text-sm font-medium text-rose-400"><?= e($email_err) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-neutral-300">Passwort</label>
                <input type="password" name="password" id="password" autocomplete="current-password"
                       class="w-full rounded-lg border border-neutral-600 bg-neutral-900 px-3 py-2.5 text-neutral-100 placeholder-neutral-500 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/40">
                <?php if ($password_err): ?>
                    <p class="mt-1.5 text-sm font-medium text-rose-400"><?= e($password_err) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 font-semibold text-white transition hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-500/50">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>
</div>

</body>
</html>

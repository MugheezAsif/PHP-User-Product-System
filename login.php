<?php include 'inc/header.php'; ?>

<?php
    if (isset($_POST['submit'])) {
        $email = $emailErr = $password = $passwordErr = '';
        // validations
        empty($_POST['email']) ? $emailErr = 'Provide an Email' : $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        empty($_POST['password']) ? $passwordErr = 'Provide a Password' : $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Fetching from database
        if (empty($emailErr) && empty($passwordErr)) {
            // checking email
            $sql = "SELECT * FROM user WHERE email='$email'";
            $res = $conn->query($sql);
            // now checking password
            if (mysqli_num_rows($res) >= 1) {
                $user = mysqli_fetch_row($res);
                if (password_verify($password, $user[3])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['logined'] = true;
                    $_SESSION['user_email'] = $email;
                    if ($user[4] == 'admin') {
                        $_SESSION['is_admin'] = true;
                        $_SESSION['admin_id'] = $user[0];
                    } else {
                        $_SESSION['is_admin'] = false;
                    }
                    header('Location: index.php');
                }
                else {
                    $passwordErr = 'Password is incorrect';
                }
            } else {
                $emailErr = 'Email not found. Please sign up';
            }
            
        }
    }
?>

<section class="login-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
                        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                             
                            <div class="form-floating mb-3">
                                
                                <input name="email" type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null; ?>" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $emailErr; ?> </p>
                                </div>
                            </div>
                            

                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control <?php echo $passwordErr ? 'is-invalid' : null; ?>" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $passwordErr; ?> </p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <input type="submit" name="submit" value="Login" class="btn btn-dark w-100">
                            </div>
                                
                            <hr class="my-4">
                            <div class="d-grid mb-2">
                                <a class="btn btn-primary" href="register.php">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include 'inc/footer.php'; ?>
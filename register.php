<?php include 'inc/header.php'; ?>

<?php
    if (isset($_POST['submit'])) {
        $name = $nameErr = $email = $emailErr = $password = $passwordErr = $passwordCErr = $passwordC = '';
        // validations
        empty($_POST['name']) ? $nameErr = 'Enter your name' : $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        empty($_POST['email']) ? $emailErr = 'Provide an Email' : $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        empty($_POST['password']) ? $passwordErr = 'Provide a Password' : $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        empty($_POST['passwordC']) ? $passwordCErr = 'Password does not match' : $passwordC = filter_input(INPUT_POST, 'passwordC', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // checking passwords
        if (isset($_POST['password']) && isset($_POST['password'])) {
            if ($password != $passwordC) {
                $passwordCErr = 'Password does not matched';
            }
        }
        // Entring record in database
        if (empty($nameErr) && empty($emailErr) && empty($passwordCErr) && empty($passwordErr)) {
            // checking for existing record
            $sql = "SELECT * FROM user WHERE email='$email'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) >= 1) {
                $emailErr = 'Account already exists.';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (name, email, password) VALUES('$name', '$email', '$password')";
                if (mysqli_query($conn, $sql)) {
                    header('Location: login.php');
                }
            }
        }
    }
?>

<section class="reg-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign Up</h5>
                        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                            <div class="form-floating mb-3">
                                <input name="name" type="name" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Name</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $nameErr; ?> </p>
                                </div>
                            </div>
                            
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
                            <div class="form-floating mb-3">
                                <input name="passwordC" type="password" class="form-control <?php echo $passwordCErr ? 'is-invalid' : null; ?>" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Confirm Password</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $passwordCErr; ?> </p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <input type="submit" name="submit" value="Sign Up" class="btn btn-outline-primary w-100">
                            </div>
                                
                            <hr class="my-4">
                            <div class="d-grid mb-2">
                                <a class="btn btn-primary" href="login.php">Sign In</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
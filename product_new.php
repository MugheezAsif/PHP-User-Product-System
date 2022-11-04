<?php include 'inc/header.php' ?>

<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['is_admin'])) {
        if ($_SESSION['is_admin']) {
            $name = $nameErr = $price = $priceErr = '';
            if (isset($_POST['submit'])) {
                // validating inputs
                empty($_POST['name']) ? $nameErr = 'Enter Name' : $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                empty($_POST['price']) ? $priceErr = 'Enter Price' : $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
                // Entring in database
                if(empty($nameErr) && empty($priceErr)) {
                    $user_id = $_SESSION['admin_id'];
                    $sql = "INSERT INTO product (name, price, userid) VALUES('$name', '$price', '$user_id')";
                    mysqli_query($conn, $sql);
                    header('Location: dashboard.php');
                }
            }
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
?>


<section class="new-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">New Product</h5>
                        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                             
                            <div class="form-floating mb-3">
                                
                                <input name="name" type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" id="floatingInput">
                                <label for="floatingInput">Product Name</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $nameErr; ?> </p>
                                </div>
                            </div>
                            

                            <div class="form-floating mb-3">
                                <input name="price" type="number" class="form-control <?php echo $priceErr ? 'is-invalid' : null; ?>" id="floatingPassword">
                                <label for="floatingPassword">Price</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $priceErr; ?> </p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <input type="submit" name="submit" value="Create" class="btn btn-dark w-100">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'inc/footer.php' ?>
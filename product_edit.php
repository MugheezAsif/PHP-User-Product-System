<?php include 'inc/header.php' ?>

<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['edit_product_id'])) {
        // Fetching Product
        $p_id = $_SESSION['edit_product_id'];
        $sql = "SELECT * FROM product WHERE id='$p_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_row($result);
        }
        // Updating
        $name = $nameErr = $price = $priceErr = '';
        if (isset($_POST['submit'])) {
            // validating inputs
            empty($_POST['name']) ? $nameErr = 'Enter Name' : $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            empty($_POST['price']) ? $priceErr = 'Enter Price' : $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
            // Entring in database
            if(empty($nameErr) && empty($priceErr)) {
                $user_id = $_SESSION['admin_id'];
                $sql = "UPDATE product SET name='$name', price='$price' WHERE id='$p_id'";
                mysqli_query($conn, $sql);
                header('Location: dashboard.php');
            }
        }
    }
?>

<section class="product-edit new-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Update Product</h5>
                        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                             
                            <div class="form-floating mb-3">
                                
                                <input value="<?php echo $product[1] ?>" name="name" type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" id="floatingInput">
                                <label for="floatingInput">Product Name</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $nameErr; ?> </p>
                                </div>
                            </div>
                            

                            <div class="form-floating mb-3">
                                <input value="<?php echo $product[2] ?>" name="price" type="number" class="form-control <?php echo $priceErr ? 'is-invalid' : null; ?>" id="floatingPassword">
                                <label for="floatingPassword">Price</label>
                                <div class="invalid-feedback">
                                    <p> <?php echo $priceErr; ?> </p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <input type="submit" name="submit" value="Update" class="btn btn-dark w-100">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php' ?>
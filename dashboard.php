<?php include 'inc/header.php'; ?>

<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['is_admin'])) {
        if($_SESSION['is_admin'] == true) {
            // fetching all products
            $products = null;
            $sql = "SELECT * FROM product";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $products = mysqli_fetch_all($result);
            }
        } else {
            header('Location: index.php');
        }
        if(isset($_POST['edit'])) {
            // edit a product
            $_SESSION['edit_product_id'] = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            header('Location: product_edit.php');
        } elseif (isset($_POST['destroy'])) {
            // delete product
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            $sql = "DELETE FROM product WHERE id='$product_id'";
            mysqli_query($conn, $sql);
            header('Location: dashboard.php');
        } 
        // Sorting 
        else if(isset($_POST['orderBy'])) {
            $order = $_POST['orderBy'];
            if ($order == 'name') {
                $sql = "SELECT * FROM product ORDER BY name";
                $result = mysqli_query($conn, $sql);
                $products = mysqli_fetch_all($result);
            } else if ($order == 'price') {
                $sql = "SELECT * FROM product ORDER BY price";
                $result = mysqli_query($conn, $sql);
                $products = mysqli_fetch_all($result);
            } else if ($order == 'default') {
                $sql = "SELECT * FROM product";
                $result = mysqli_query($conn, $sql);
                $products = mysqli_fetch_all($result);
            }
        }
    } else {
        header('Location: index.php');
    }
?>

<script>
    function showResult(str) {
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            
            if (this.readyState==4 && this.status==200) {
                var product = document.querySelectorAll('.p-details');
                if (str.length != 0) {
                    for (i = 0; i < product.length; i++) {
                        var p_name = product[i].querySelector(".p-d-name").innerText;
                        if (p_name.indexOf(str) != 0) {
                            product[i].classList.add('d-none');
                        }
                    }
                } else {
                    product.forEach((node) => node.classList.remove('d-none'));
                }
            }
        }
        xmlhttp.open("POST","dashboard.php?q="+str,true);
        xmlhttp.send();
    }
</script>

<section class="dashboard-section dashboard py-5">
    <div class="container">
        <div class="section-header text-center">
            <h2>Dashboard</h2>
            <p>Here you can manage all of your products.</p>
        </div>
    </div>
    <div class="container">
        <div>
            <a href="product_new.php" class="btn my-3">New Product</a>
        </div>
        <div class="search-box my-2">
            <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                <input onkeyup="showResult(this.value)" name="search_name" type="text" class="form-control" id="floatingInput" placeholder="Search"> 
                
            </form>
        </div>
    </div>
    
    <div class="container pb-5">
        <?php if($products) : ?>
            <h3>All Products</h3>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < sizeof($products); $i++) : ?>
                        <tr class="p-details">
                            <th scope="row"><?php echo $products[$i][0] ?></th>
                            <td class="p-d-name"><?php echo $products[$i][1] ?></td>
                            <td><?php echo $products[$i][2] ?></td>
                            <td>
                                <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                                    <input name="product_id" type="hidden" value="<?php echo $products[$i][0] ?>">
                                    <input class="btn btn-sm btn-secondary-danger" type="submit" name="edit" value="Edit">
                                </form>
                            </td>
                            <td>
                                <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                                    <input name="product_id" type="hidden" value="<?php echo $products[$i][0] ?>">
                                    <input class="btn btn-sm btn-outline-danger" type="submit" name="destroy" value="destroy">
                                </form>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                </table>
            </div>
            <div>
                <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                    <p>Order By</p>
                    <select name="orderBy" class="form-select">
                        <option>Default</option>
                        <option value="name" >Name</option>
                        <option value="price">Price</option>
                    </select>
                    <input class="btn my-1" type="submit" name="order" value="See">
                </form>
            </div>
        <?php else : ?>
            <p>No Products Yet!</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
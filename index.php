<?php include 'inc/header.php'; ?>

<?php
  $products = null;
  $sql = "SELECT * FROM product";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result)) {
    $products = mysqli_fetch_all($result);
  }
?>

<section class="hero">
    <div class="container mt-5">
      <div class="row p-5 gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
          <h2>Welcome to <span>MySite</span></h2>
          <p>In this project you can view products. Sign in to view prices as well. Sign in as admin in order to customize the products. I hope you like it!</p>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <?php if (isset($_SESSION['logined'])) : ?>
              <?php if ($_SESSION['logined']) : ?>
                  <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                      <input type="submit" name="sign-out" class="btn-reg btn-lg m-3 btn px-5" value="Sign Out">
                  </form>
                  <?php if ($is_admin == true) : ?>
                      <a class="btn-login btn-lg m-3 btn px-4" href="dashboard.php">Dashboard</a>
                  <?php endif; ?>
              <?php else : ?>    
                  <a href="register.php" class="btn-reg btn-lg m-3 btn px-5">Register</a>
                  <a href="login.php" class="btn-login btn-lg m-3 btn px-4">Login</a>
              <?php endif; ?>
            <?php else : ?>
              <a href="register.php" class="btn-reg btn-lg m-3 btn px-5">Register</a>
              <a href="login.php" class="btn-login btn-lg m-3 btn px-4">Login</a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="img/hero.svg" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
        </div>
      </div>
    </div>
</section>

<section class="products py-5">
  <div class="container py-2">
        <div class="section-header text-center">
            <h2>Our Products</h2>
            <p>We provide a vide verity of products.</p>
        </div>
    </div>
    <div class="container">
      <?php if ($products) : ?>
        <div class="row">
          <?php for ($i = 0; $i < sizeof($products); $i++) : ?>
            <div class="col-md-4 my-2" data-aos="fade-up" data-aos-delay="100">
              <div class='box m-3 py-5 px-3 shadow rounded bg-light'>

                  <h3><span>Name </span><?php echo $products[$i][1] ?></h3>
                  <?php if (isset($_SESSION['logined'])) : ?>
                    <?php if ($_SESSION['logined'] == true) : ?>
                      <p>Price : <?php echo $products[$i][2] ?>£</p>
                    <?php endif; ?>
                  <?php endif; ?>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      <?php else : ?>
        <p>Sorry No Products Yet!</p>
      <?php endif; ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
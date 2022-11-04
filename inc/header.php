<?php include 'config/database.php'; ?>

<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_admin = $_SESSION['is_admin'] ?? null;
    if (isset($_SESSION['logined'])) {
        if ($_SESSION['logined'] == true) {
            $login = true;
        } else {
            $login = false;
        }
    } else {
        $login = false;
    }
    if (isset($_POST['sign-out'])) {
        $_SESSION['logined'] = false;
        $_SESSION['user_email'] = '';
        $_SESSION['is_admin'] = false;
        $login = false;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PHP First Project</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/styles.css?<?php echo time(); ?>">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </head>
    <body>
        <section>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="https://github.com/MugheezAsif">Mugheez</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <?php if ($login == true) : ?>
                                <li class="nav-item">
                                <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="POST">
                                    <input type="submit" name="sign-out" class="nav-link" value="Sign Out">
                                </form>
                                </li>
                                <?php if ($is_admin == true) : ?>
                                    <li>
                                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                                    </li>
                                <?php endif; ?>
                            <?php else : ?>    
                                <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="register.php">Sign Up</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    
                    </div>
                </div>
            </nav>
        </section>
    
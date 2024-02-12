<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/styleLog.css">
    <!-- Estilo boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Login</title>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                    <form method="POST" action="bd/bd_login.php">

                    <?php
                        session_start();
                        // Mostrar el mensaje de error si existe
                        if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger mt-3 text-center" role="alert">' . $_SESSION['error_message'] . '</div>';
                            $_SESSION['error_message'] = ''; // Limpiar la variable de sesión después de mostrar el mensaje
                            session_unset();
                        }
                    ?>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form3Example3" class="gmail form-control form-control-lg" placeholder="Enter a valid email address" name="email" required/>
                            <!--<label class="form-label" for="form3Example3">Email address</label>-->
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="pass form-control form-control-lg" placeholder="Enter password" name="password" required />
                            <!--<label class="form-label" for="form3Example4">Password</label>-->
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                        <!--<p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="crearCuenta.php" class="link-danger">Register</a></p>-->
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
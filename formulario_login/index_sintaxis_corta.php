<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_POST) {

    $usuario = $_POST["txtUsuario"];
    $clave = $_POST["txtClave"];

    if ($usuario != "" && $clave != "") {
        header("Location: http://localhost/php/formulario_login/acceso-confirmado.php");
    } else {
        $msg = "Válido para usuarios registrados";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-left py-5">
                <h1>Formulario de ingreso</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <?php if (isset($msg)) : ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $msg; ?>
                        </div>
                        <?php endif; ?>
                <form action="" method="post">
                    <div class="pb-3">
                        <label for="">Usuario:</label>
                        <input type="text" name="txtUsuario" id="txtUsuario" class="form-control">
                    </div>
                    <div class="pb-3">
                        <label for="">Clave:</label>
                        <input type="password" name="txtClave" id="txtClave" class="form-control">
                    </div>
                    <div class="my-2 mx-auto">
                        <button type="submit" name="btnIngresar" class="btn btn-primary">INGRESAR</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
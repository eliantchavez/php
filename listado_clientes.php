<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$aClientes = array();

session_start();

if (isset($_SESSION["listadoClientes"])) {
    //Si existe la variable de session listadoClientes asigno su contenido a aClientes
    $aClientes = $_SESSION["listadoClientes"];
} else {
    $aClientes = array();
}

//Pregunta si es postback sea para enviar o eliminar todos
if (isset($_POST["btnEnviar"])) {
    //Si hace click en Enviar entonces:
    //Asignamos en variables los datos que vienen del formulario
    $nombre = $_POST["txtNombre"];
    $dni = $_POST["txtDni"];
    $telefono = $_POST["txtTelefono"];
    $edad = $_POST["txtEdad"];

    //Creamos un array que contendrá el listado de clientes
    $aClientes[] = array("nombre" => $nombre, "dni" => $dni, "telefono" => $telefono, "edad" => $edad);

    //Actualiza el contenido de variable de session
    $_SESSION["listadoClientes"] = $aClientes;
}
//Si hace click en Eliminar:
//session_destroy();
if (isset($_POST["btnEliminar"])) {
    session_destroy();
    $aClientes = array();
}

//Pregunta si viene pos en la query string
if(isset($_GET["pos"])){
    //Recupero el dato que viene desde la query string vía get
    $pos = $_GET["pos"];
    //Elimina la posición del array indicado
    unset($aClientes[$pos]);
    //Actualizo la variable de session con el array actualizado
    $_SESSION["listadoClientes"] = $aClientes;
    header("Location: listado_clientes.php");

}




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <h1>Listado de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-3 offset-1 me-5">
                <form action="" method="POST" class="form">

                    <label for="txtNombre">Nombre:</label>
                    <input type="text" name="txtNombre" id="txtNombre" placeholder="Ingrese el nombre y apellido" class="form-control my-2">

                    <label for="txtDni">DNI:</label>
                    <input type="text" name="txtDni" id="txtDni" class="form-control my-2">

                    <label for="txtTelefono">Teléfono:</label>
                    <input type="text" name="txtTelefono" id="txtTelefono" class="form-control my-2">

                    <label for="txtEdad">Edad:</label>
                    <input type="text" name="txtEdad" id="txtEdad" class="form-control my-2">

                    <button type="submit" name="btnEnviar" class="btn btn-primary">Enviar</button>
                    <button type="submit" name="btnEliminar" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
            <div class="col-6 ms-5">
                <table class="table table-hover shadow border">
                    <thead>
                        <th>Nombre:</th>
                        <th>DNI:</th>
                        <th>Teléfono:</th>
                        <th>Edad:</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php foreach ($aClientes as $pos => $cliente) : ?>
                            <tr>
                                <td> <?php echo $cliente["nombre"] ?></td>
                                <td> <?php echo $cliente["dni"] ?> </td>
                                <td> <?php echo $cliente["telefono"] ?> </td>
                                <td> <?php echo $cliente["edad"] ?> </td>
                                <td><a href="listado_clientes.php?pos=<?php echo $pos; ?>" a><i class="bi bi-trash-fill"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>
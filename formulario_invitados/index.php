<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Si existe el archivo invitados lo abrimos y cargamos en una variable del tipo array a los dni permitidos
if (file_exists("invitados.txt")) {
    $archivo = fopen("invitados.txt", "r"); //Abrimos el archivo "fopen", lo abrimos en modo lectura "r"
    $aDocumentos = fgetcsv($archivo, 0, ","); //Recibe como primer parámetro el "$archivo" y como segundo el límite de caracteres y por último el delimitador
} else {
    //Sino el array queda como un array vacío
    $aDocumentos = array();
}

if ($_POST) {
    if (isset($_POST["btnProcesar"])) {
        $documento = $_REQUEST["txtDocumento"];
        //Si el DNI ingresado se encuentra en la lista se mostrará un mensaje de bienvenido
        if (in_array($documento, $aDocumentos)) { //Con "in_array" busco elementos dentro de un array, primero coloco el elemento a buscar y luego el lugar de búsqueda
            $mensaje = "Bienvenido.";

            //Sino un mensaje de "No se encuentra en la lista de invitados"
        } else {
            $mensaje = "No se encuentra en la lista de invitados.";
        }
    }



    if (isset($_POST["btnVip"])) {
        $codigo = $_REQUEST["txtCodigo"]; //Recuperamos la variable "$codigo" del formulario
        //Si el código es "verde" entonces mostrará "Su código de acceso es:"
        if ($codigo == "verde") {
            $mensaje = "Su código de acceso es: " . rand(1000, 9999); //El punto "." lo uso para concatenar la variable y el rand
        } else {
            $mensaje = "Ud. no tiene pase VIP";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Lista de invitados</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12 my-5">
                <h1>Lista de invitados</h1>
            </div>
        </div>
        <?php if (isset($mensaje)) : ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <?php echo $mensaje ?>
                </div>
            </div>
        <?php endif ?>
        <div class="col-12 pb-3">
            <p>Complete el siguiente formulario:</p>
        </div>
        <div class="col-6">
            <form action="" method="post">
                <div class="row">
                    <div class="col-12">
                        <p>Ingrese el DNI:</p> <input type="text" name="txtDocumento" class="form-control">
                        <input type="submit" name="btnProcesar" value="Verificar invitado" class="btn btn-primary my-2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Ingresa el código secreto para el pase VIP:</p>
                        <input type="password" name="txtCodigo" class="form-control">
                        <input type="submit" name="btnVip" value="Verificar código" class="btn btn-primary my-2">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Preguntar si existe el archivo
if (file_exists("archivo.txt")) {
    //Vamos a leerlo y almacenamos el contenido en jsonClientes
    $jsonClientes = file_get_contents("archivo.txt"); //file_get_contents sirve para obtener datos y file_put_contents poner/guardar datos 

    //Convertir jsonClientes en un array llamado aClientes
    $aClientes = json_decode($jsonClientes, true);
} else {
    //Si no existe el archivo
    //Creamos un aClientes inicializando como un array vacío
    $aClientes = array();
}

$pos = (isset($_GET["pos"])) && $_GET["pos"] >= 0 ? $_GET["pos"] : "";

if ($_POST) {
    //trim = elimina los espacios que estén atrás o adelante automáticamente
    $dni = trim($_POST["txtDni"]);
    $nombre = trim($_POST["txtNombre"]);
    $telefono = trim($_POST["txtTelefono"]);
    $correo = trim($_POST["txtCorreo"]);
    $nombreImagen = "";

    if ($pos >= 0) {
        
        if   ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi"); //Entrega un nombre aleatorio en basado en una fecha específica
            $archivo_tmp = $_FILES["archivo"]["tmp_name"];
            $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") { //Si $extension está en cualquiera de los tres formatos escritos, entonces realiza el siguiente paso
                $nombreImagen = "$nombreAleatorio.$extension";
                move_uploaded_file($archivo_tmp, "imagenes/$nombreAleatorio.$extension");
            }

            //Eliminar la imagen anterior
            if($aClientes[$pos]["imagen"] != "" && file_exists("imagenes/".$aClientes[$pos]["imagen"])){
            unlink("imagenes/" . $aClientes[$pos]["imagen"]);
        }
        
        }   else{
            //Mantener el nombreImagen que teníamos antes
            $nombreImagen = $aClientes[$pos] ["imagen"];
        }  
        
        //Actualizar
        $aClientes[$pos] = array(
            "dni"      => $dni,
            "nombre"   => $nombre,
            "telefono" => $telefono,
            "correo"   => $correo,
            "imagen"   => $nombreImagen);
    
    } else {
       
        if   ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
            $nombreAleatorio = date("Ymdhmsi"); //2021010420453710
            $archivo_tmp = $_FILES["archivo"]["tmp_name"];
            $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                $nombreImagen = "$nombreAleatorio.$extension";
                move_uploaded_file($archivo_tmp, "imagenes/$nombreAleatorio.$extension");
            }
        }

        //Insertar
        $aClientes[] = array(
            "dni"      => $dni,
            "nombre"   => $nombre,
            "telefono" => $telefono,
            "correo"   => $correo,
            "imagen"   => $nombreImagen);
    }

    //Convertir el array de clientes a jsonClientes
    $jsonClientes = json_encode($aClientes);

    //Almacenar el string jsonClientes en el "archivo.txt"
    file_put_contents("archivo.txt", $jsonClientes);
}
$pos = isset($_GET["pos"]) && $_GET["pos"] >= 0 ? $_GET["pos"] : "";


if (isset($_GET["do"]) && $_GET["do"] == "eliminar") {
    //Eliminar del array aClientes la posición a borrar unset()
    unset($aClientes[$pos]);

    //Convertir el array en json
    $jsonClientes = json_encode($aClientes);

    //Almacenar el json en el archivo
    file_put_contents("archivo.txt", $jsonClientes);
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12 py-5 text-center">
                <h1>Registro de clientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-3 offset-1 me-5">
                <form action="" method="post" enctype="multipart/form-data" class="form">

                    <label for="">DNI: *</label>
                    <input type="text" id="txtDni" name="txtDni" class="form-control my-2" required value="<?php echo isset($aClientes[$pos]) ? $aClientes[$pos]["dni"] : ""; ?>">

                    <label for="">Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control my-2" required value="<?php echo isset($aClientes[$pos]) ? $aClientes[$pos]["nombre"] : ""; ?>">

                    <label for="">Teléfono</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" class="form-control my-2" required value="<?php echo isset($aClientes[$pos]) ? $aClientes[$pos]["telefono"] : ""; ?>">

                    <label for="">Correo: *</label>
                    <input type="text" id="txtCorreo" name="txtCorreo" class="form-control my-2" required value="<?php echo isset($aClientes[$pos]) ? $aClientes[$pos]["correo"] : ""; ?>">

                    <label for="">Archivo adjunto</label>
                    <input type="file" id="archivo" name="archivo" accept=".jpg, .jpeg, .png">
                    <small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="index.php" class="btn btn-danger my-2">NUEVO </a>
                </form>
            </div>
            <div class="col-6 ms-5">
                <table class="table table-hover border">
                    <tr>
                        <th>Imagen</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($aClientes as $pos => $cliente) : ?>
                        <tr>
                        <td>
                            <?php if ($cliente["imagen"] != "") : ?>
                                <img src="imagenes/<?php echo $cliente["imagen"]; ?>" class="img-thumbnail" >
                            <?php endif; ?>
                        </td>
                        <td><?php echo $cliente["dni"] ?></td>
                        <td><?php echo $cliente["nombre"] ?></td>
                        <td><?php echo $cliente["correo"] ?></td>
                        <td>
                            <a href="index.php?pos=<?php echo $pos; ?>&do=editar"><i class="bi bi-pencil"></i></a>
                            <a href="index.php?pos=<?php echo $pos; ?>&do=eliminar"><i class="bi bi-trash"></i></a>
                        </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </main>
</body>

</html>
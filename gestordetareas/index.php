<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Paso 1: Recuperar el archivo de info. que está almacenado (string Json). 
//El cual lo vamos a pasar a un array para poder trabajarlo, modificarlo, recorrerlo.
//El array que va a contener la info. del Json va a ser la variable "$aTareas".

//Pregunto si exite el archivo.txt para saber si hay datos cargados
if (file_exists("archivo.txt")) {
    //Si el archivo existe, cargo los datos en la variable aTareas
    $strJson = file_get_contents("archivo.txt");
    $aTareas = json_decode($strJson, true);
} else {
    //Si el archivo no existe en porque no hay tareas(datos)
    $aTareas = array(); 
}

//Vamos a preguntar si está "seteado" "id" y si es mayor que 0. 
//En ese caso creamos la variable $id diciendo contendrá lo "seteado" de $_GET["id"] (se recupera el id).
if (isset($_GET["id"]) && ($_GET["id"]) >= 0) {
    $id = $_GET["id"];
} else {
    $id = "";       //Si el archivo no está seteado entonces queda en vacío
}                   //$id = isset($_GET["id"]) && $_GET["id"] >= 0 ? $_GET["id"] : "";

if ($_POST) { //Declaramos variables, y le asignamos los datos que vengan del formulario (txtTitulo, txtDescripcion, etc...)
    $titulo      = $_POST["txtTitulo"];
    $prioridad   = $_POST["lstPrioridad"];
    $usuario     = $_POST["lstUsuario"];
    $estado      = $_POST["lstEstado"];
    $descripcion = $_POST["txtDescripcion"];

    if ($id >= 0) {
        //Estoy editando/actualizando una tarea(datos)
        $aTareas[$id] = array(      //Creamos un array asociativo
            "fecha"       => $aTareas["$id"]["fecha"],
            "prioridad"   => $prioridad,
            "usuario"     => $usuario,
            "estado"      => $estado,
            "titulo"      => $titulo,
            "descripcion" => $descripcion
        );
    } else {
        //Estoy insertando/creando una tarea nueva
        $aTareas[] = array( //Los corchetes están vacíos, ya que estamos creando un id nuevo. Por lo tanto la variable $id está vacía. 
            "fecha"       => date("d/m/Y"), //Lo cual nos daría error si intentamos "invocarla"    
            "prioridad"   => $prioridad,
            "usuario"     => $usuario,
            "estado"      => $estado,
            "titulo"      => $titulo,
            "descripcion" => $descripcion
        );
    }
    //Convertimos el array de aTareas en json 
    $strJson = json_encode($aTareas);
    //Almacenamos en un archivo.txt el json con file_put_contents
    file_put_contents("archivo.txt", $strJson); //Dentro del "()" va primero el destino y luego el archivo a colocar dentro
}
//Preguntamos si está seteado "do" y si "do" es igual a "eliminar"
if (isset($_GET["do"]) && $_GET["do"] == "eliminar") { //Si es true, entonces procede
    unset($aTareas[$id]);                             //A eliminar con "unset" la variable de session "$aTareas["id"]"

    //El siguiente paso va a ser actualizar el archivo
    //Convertimos el array $aTareas en Json
    $strJson = json_encode($aTareas);

    //Almacenamos el json en el archivo
    file_put_contents("archivo.txt", $strJson);

    //Redireccionamos a index.php para limpiar la barra de direcciones
    header("Location:index.php");
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <title>Gestor de tareas</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="text-center col-12 my-4">
                <h1>Gestor de tareas</h1>
            </div>
        </div>
        <div class="row pb-3">
            <div>
                <form action="" method="post">
                    <div class="row">
                        <div class="py-1 col-4">
                            <label for="lstPrioridad">Prioridad</label>
                            <select name="lstPrioridad" id="lstPrioridad" class="form-control"> <!-- Pregunta si está seteado $aTareas[$id] y si la variable aTareas[id] ["prioridad"] es igual a "Alta"-->
                                <option value="" disabled selected>Seleccionar</option>         <!-- Si es así entonces coloca el contenido de la variable aTareas[id] ["prioridad"] como "selected". Sino deja espacio en blanco -->
                                <option value="Alta"  <?php echo isset($aTareas[$id])   && $aTareas[$id] ["prioridad"]  == "Alta"?  "selected": "";  ?> >Alta</option> 
                                <option value="Media" <?php echo isset($aTareas[$id])   && $aTareas[$id] ["prioridad"]  == "Media"? "selected" : ""; ?> >Media</option>
                                <option value="Baja"  <?php echo isset($aTareas[$id])   && $aTareas[$id] ["prioridad"]  == "Baja"? "selected" : "";  ?> >Baja</option>
                            </select>
                        </div>
                        <div class="py-1 col-4">
                            <label for="lstUsuario">Usuario</label>
                            <select name="lstUsuario" id="lstUsuario" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Ana"     <?php echo isset($aTareas[$id])  && $aTareas[$id] ["usuario"] == "Ana"? "selected" : "";      ?> >Ana</option>
                                <option value="Bernabé" <?php echo isset($aTareas[$id])  && $aTareas[$id] ["usuario"] == "Bernabé"? "selected" : "";  ?> >Bernabé</option>
                                <option value="Daniela" <?php echo isset($aTareas[$id])  && $aTareas[$id] ["usuario"] == "Daniela" ? "selected" : ""; ?> >Daniela</option>
                            </select>
                        </div>
                        <div class="py-1 col-4">
                            <label for="lstEstado">Estado</label>
                            <select name="lstEstado" id="lstEstado" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Sin asignar" <?php echo isset($aTareas[$id]) && $aTareas[$id] ["estado"] == "Sin asignar"? "selected" : ""; ?> >Sin asignar</option>
                                <option value="Asignado"    <?php echo isset($aTareas[$id]) && $aTareas[$id] ["estado"] == "Asignado"? "selected" : "";    ?> >Asignado</option>
                                <option value="En proceso"  <?php echo isset($aTareas[$id]) && $aTareas[$id] ["estado"] == "En proceso"? "selected" : "";  ?> >En proceso</option>
                                <option value="Terminado"   <?php echo isset($aTareas[$id]) && $aTareas[$id] ["estado"] == "Terminado"? "selected": "" ;   ?> >Terminado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 py-1">
                            <label for="txtTitulo">Título</label>
                            <input type="text" id="txtTitulo" name="txtTitulo" class="form-control my-2" required value="<?php echo isset($aTareas[$id])? $aTareas[$id]["titulo"] :""; ?>"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 py-1">
                            <label for="txtDescripcion">Descripción</label>
                            <textarea name="txtDescripcion" id="txtDescripcion" required class="form-control"><?php echo isset($aTareas[$id])? $aTareas[$id] ["descripcion"] : ""; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 py-1 text-center">
                            <button type="submit" class="btn btn-primary">ENVIAR</button>
                            <a href="index.php" class="btn btn-secondary"> CANCELAR</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (count($aTareas)) : ?>
            <div class="col-12 pt-3">
                <table class="table table-hover border my-5">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de inserción</th>
                            <th>Título</th>
                            <th>Prioridad</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Recorro la variable $aTareas, cada una es una tarea en particular-->
                        <?php foreach ($aTareas as $pos => $tarea) : ?>
                            <!--Tomo $aTareas y lo "divido" en tareas individuales ($tarea)-->
                            <tr>
                                <!-- $pos representa las posiciones (sub 0, sub 1, etc...)-->
                                <td> <?php echo $pos ?> </td>
                                <td> <?php echo $tarea["fecha"];    ?></td>
                                <td> <?php echo $tarea["titulo"]    ?></td>
                                <td> <?php echo $tarea["prioridad"] ?></td>
                                <td> <?php echo $tarea["usuario"]   ?></td>
                                <td> <?php echo $tarea["estado"]    ?></td>
                                <td>
                                    <!--Se les da funciones a los íconos de bootstrap "id" = $pos-->
                                    <!--La función de cada ícono va a ser identificar qué posición es la que quiero editar o quitar-->
                                    <!--Todo gracias a función "id"-->
                                    <a href="?id=<?php echo $pos ?>&do=editar"   class="btn btn secondary" ><i class="bi bi-pencil-square"> </i></a>
                                    <a href="?id=<?php echo $pos ?>&do=eliminar" class="btn btn danger"    ><i class="bi bi-trash-fill">    </i></a>
                                </td>
                                <!--Uso el "&" para concatenar valores y el "do" para que tenga una etiqueta-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        Aún no se han cargado tareas.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>
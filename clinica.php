<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$aPacientes = array();
$aPacientes[] = array(
    "dni" => "33.765.012",
    "nombre" => "Ana Acuña",
    "edad" => 45,
    "peso" => 81.50,   
);

$aPacientes[] = array(
    "dni" => "23.684.385",
    "nombre" => "Gonzalo Bustamante",
    "edad" => 66,
    "peso" => 79.36,   
);

$aPacientes[] = array(
    "dni" => "34.648.262",
    "nombre" => "Daniel López",
    "edad" => 41,
    "peso" => 74.4,   
);

$aPacientes[] = array(
    "dni" => "21.625.481",
    "nombre" => "Lucía Acosta",
    "edad" => 33,
    "peso" => 62.35,   
);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <h1>Listado de pacientes</h1>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-hover border">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre y apellido</th>
                        <th>Edad</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($aPacientes as $paciente){ ?>
                    <tr>
                        <td><?php echo $paciente ["dni"]?></td>
                        <td><?php echo $paciente ["nombre"]?></td>
                        <td><?php echo $paciente ["edad"]?></td>
                        <td><?php echo $paciente ["peso"]?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    
</body>
</html>
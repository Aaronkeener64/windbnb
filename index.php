<?php
    require 'conexion.php';
    $db = new Database();
    $con = $db->conectar();


    if(isset($_POST['agregar'])) {
        $nuevo_id = $_POST['nuevo_id'];
        $nuevo_nom = $_POST['nuevo_nom'];
        $nueva_edad = $_POST['nueva_edad'];
        $nueva_eps = $_POST['nueva_eps'];
        $nuevo_sexo = $_POST['nuevo_sexo'];
        $nueva_fecha = $_POST['nueva_fecha_ingresada'];
        $nueva_desc = $_POST['nueva_desc'];
        $nuevo_doc = $_POST['nuevo_doc'];
        $nueva_enfer = $_POST['enfer_id'];
        $agregar = $con->prepare("INSERT INTO pacientes (pac_id, pac_nombre, pac_edad, pac_EPS, pac_sexo, pac_fecha_ingreso, urg_descripcion, doc_id,enfer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $agregar->execute([$nuevo_id,$nuevo_nom, $nueva_edad, $nueva_eps, $nuevo_sexo, $nueva_fecha, $nueva_desc, $nuevo_doc, $nueva_enfer]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>urgencias</title>
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../config_template/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../config_template/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../config_template/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>
<body>
    <h2>agregar un nuevo paciente</h2>
    
        <form method="post" class="formulario" id="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3" id="grupo__usuario">
                <label for="nuevo_id" class="formulario__label">Documento *</label>
                <input type="number" class="form-control" name="nuevo_id" id="nuevo_id" placeholder="Código (obligatorio)" requiered>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">
                    El documento tiene que ser de 6 a 11 dígitos y solo puede contener numeros.</p>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" name="nuevo_nom" id="nuevo_nom" placeholder="nombre" required>
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="nueva_edad" id="nueva_edad" placeholder="edad" requiered>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="nueva_eps" id="nueva_eps" placeholder="EPS afiliada" requiered>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="nuevo_sexo" id="nuevo_sexo" placeholder="sexo" requiered>
            </div>
            <div class="mb-3">
                <input type="date" class="form-control" name="nueva_fecha_ingresada" id="nueva_fecha_ingresada" placeholder="" requiered>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="nueva_desc" id="nueva_desc" placeholder="descripcion de la urgencia" requiered>
            </div>
            
            <div class="mb-3">
            <select class="form-control" name="nuevo_doc"  required>
                            <option value="" selected="">"Doctor encargado"</option>
                                <?php
                /*consulta que muestra las opciones en el select de una llave foranea*/
                                    $statement=$con->prepare('SELECT * FROM doctores');
                                    $statement->execute();
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value=" . $row['doc_id'] .">". $row['doc_nombre']."</option>";
                                    }
                                ?>
            </select>
            </div>
            <div class="mb-3">
            <select class="form-control" name="enfer_id"  required>
                            <option value="" selected="">"enfermedad diagnosticada"</option>
                                <?php
                /*consulta que muestra las opciones en el select de una llave foranea*/
                                    $statement=$con->prepare('SELECT * FROM enfermedades');
                                    $statement->execute();
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value=" . $row['enfer_id'] .">". $row['enfer_nombre']."</option>";
                                    }
                                ?>
            </select>
            </div>
            <button type="submit" class="btn btn-primary" name="agregar">Agregar</button>
        </form>
    <h1>lista de pacientes ingresados</h1>
    <?php
                $insert = $con->prepare('SELECT * FROM pacientes');
                $insert->execute();
                $resul = $insert->fetchAll(PDO::FETCH_ASSOC);
                
                $i = 0;
                

            ?>
            
  

            <table border="1">
                <tr>
                    <td>#</td>
                    <td>ID</td>
                    <td>Nombres</td>
                    <td>edad</td>
                    <td>EPS</td>
                    <td>sexo</td>
                    <td>fecha ingreso</td>
                    <td>descripcion</td>
                    <td>doctor</td>
                    <td>enfermedad diagnosticada</td>
                </tr>
                
                <?php
                foreach ($resul as $row) {
                $i++;
                
                ?>
                    <tr >
                        <td><?php echo $i?></td>
                        <td style="width:100px;"><?php echo $row['pac_id'] ?></td>
                        <td style="width:120px;"><?php echo $row['pac_nombre'] ?></td>
                        <td style="width:90px;"><?php echo $row['pac_edad'] ?></td>
                        <td style="width:120px;"><?php echo $row['pac_EPS'] ?></td>
                        <td style="width:80px;"><?php echo $row['pac_sexo'] ?></td>
                        <td style="width:120px;"><?php echo $row['pac_fecha_ingreso'] ?></td>
                        <td style="width:250px;"><?php echo $row['urg_descripcion'] ?></td>
                    <td style="width:120px;"><?php $statement = $con->prepare('SELECT doc_nombre FROM doctores WHERE doc_id = ?');
                                                $statement->execute([$row["doc_id"]]);
                                                $mostrar = $statement->fetch(PDO::FETCH_ASSOC);
                                                echo $mostrar["doc_nombre"]; ?></td>
                        <td style="width:120px;"><?php $statement = $con->prepare('SELECT enfer_nombre FROM enfermedades WHERE enfer_id = ?');
                                                        $statement->execute([$row["enfer_id"]]);
                                                        $enfermedad = $statement->fetch(PDO::FETCH_ASSOC);
                                                        echo $enfermedad["enfer_nombre"]; ?></td>
                        


                    
                    
                </tr>
                <?php } ?>

                
            </table>


            <script src="jquery.js"></script>

            
	        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>



</body>
</html>
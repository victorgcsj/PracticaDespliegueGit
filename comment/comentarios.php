<?php
$accion = $_REQUEST['accion'];
    if($accion == 'php'){
        $pagina = 'php';
    }else if($accion == 'javascript'){
        $pagina = 'javascript';
    }
    if (isset($_POST['boton'])){
        $nombre = $_POST["nombre"];
        $comentario = $_POST["comentario"];
        $fecha = date('H:i:s d/m/Y');

        $conexion = mysqli_connect('localhost','root','','despliegue');
        $stmt = $conexion->stmt_init();
        $stmt->prepare("INSERT INTO COMMENT (nombre, comentario, fechahora, lenguaje) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss",$nombre,$comentario,$fecha,$pagina);
        $stmt->execute();
        $conexion->close();
    }

?>
<div class="container-fluid text-center">  
    <form action="#" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="nombre"  placeholder="Tu nombre" required>
        </div>
        <label for="comentario">Comentario</label>
        <div class="form-group">
            <textarea rows="4" cols="200" name="comentario" id="comment"required>
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="boton">Guardar Comentario</button>
    </form>
    <div id="padre">
          <?php 
            $conexion = mysqli_connect('localhost','root','','despliegue');
            $stmt = $conexion->stmt_init();
            $stmt->prepare("SELECT nombre, comentario, fechahora FROM COMMENT WHERE lenguaje = ? ORDER BY  fechahora DESC");
            $stmt->bind_param('s',$pagina);
            $stmt->execute();

            $resultado = $stmt->get_result();
            while($fila = $resultado->fetch_assoc()){
                echo '<div id="hijo"><p>' . $fila['nombre'] . '</p>' .
                    '<p>' . $fila['comentario'] . '</p>' .
                    '<p>' .$fila['fechahora'] . '</p></div>';
            }
          ?>  
    </div>
</div>
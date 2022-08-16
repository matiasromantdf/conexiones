<?php
//crear conexion pdo
$conexion = new PDO('mysql:host=localhost;dbname=conexiones', 'root', '');

if(isset($_POST['accion'])){

   if( $_POST['accion'] == 'crear'){
    $tipo = $_POST['tipo'];
    $numero_leg=$_POST['numero'];
    $titular = $_POST['titular'];
    $fecha_inicio = $_POST['fecha'];
    $matriculado = $_POST['matriculado'];

    $calle = $_POST['calle'];
    $numero = $_POST['direccionnumero'];
    $depto = $_POST['depto'];
    $zona = $_POST['zona'];

    

    //insertar datos en la tabla tramite
    $sql = "INSERT INTO tramite (TIPO_TRAMITE, NUMERO_TRAMITE, TITULAR_TRAMITE, FECHA_TRAMITE, NUMERO_MATRICULA) VALUES ('$tipo', '$numero_leg', '$titular', '$fecha_inicio', '$matriculado')";
    //ejecutar consulta y obtener el id del registro insertado
    $id = $conexion->query($sql);
    $id = $conexion->lastInsertId();

    //establecer zona horaria en argentina
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $momento = date('Y-m-d H:i:s');

    //insertar el estado
    $sql = "INSERT INTO estado (ID_TRAMITE, ID_TIPO_ESTADO, FECHA_ESTADO) VALUES ('$id', '1', '$momento')";
    $conexion->query($sql);
    $id_estado = $conexion->lastInsertId();

    //si hay archivos adjuntos guardardar en la carpeda fotos y registrar direccion en tabla fotos
    if(isset($_FILES['fotos'])){
        //crear carpeta fotos si no existe
        if(!file_exists('fotos')){
            mkdir('fotos');
        }

        //crear nombre de archivo aleatorio
        $nombre_archivo = uniqid();

        $extension = pathinfo($_FILES['fotos']['name'], PATHINFO_EXTENSION);
        //reducir el tamaño del archivo al 20%
        $original = $_FILES['fotos']['tmp_name'];
        $nuevo = imagecreatefromjpeg($original);
        imagejpeg($nuevo, 'fotos/'.$nombre_archivo.'.'.$extension, 20);

        //guardar archivo en la carpeta fotos
       // move_uploaded_file($nuevo, 'fotos/'.$nombre_archivo.'.'.$extension);
        //insertar direccion en tabla fotos
        $sql = "INSERT INTO fotos (ID_ESTADO, FOTO) VALUES ('$id_estado', '$nombre_archivo.$extension')";
        $conexion->query($sql);
    }

    $sql = "update tramite set ultimo_estado = '1' where ID_TRAMITE = '$id'";
    $conexion->query($sql);   

    
    //insertar datos en la tabla direccion
    $sql2 = "INSERT INTO direccion (calle_direccion, numero_direccion, depto_direccion, zona_direccion, id_tramite) VALUES ('$calle', '$numero', '$depto', '$zona', '$id')";
    //ejecutar consulta
    $conexion->query($sql2);
    //cerrar conexion
    $conexion = null;
   
    if ($id) {
        echo 'ok';
    } else {
        echo 'error';
    }


   }
    
}
//si la accion es consultar-matriculado
if(isset($_GET['accion'])){

   if($_GET['accion'] == 'consultar-matriculado'){
        
    //crear conexion pdo
    $conexion = new PDO('mysql:host=localhost;dbname=conexiones', 'root', '');
    //consultar datos de la tabla tramite
    $sql = "SELECT * FROM matriculado WHERE NUMERO_MATRICULA = '$_GET[matriculado]'";
    //ejecutar consulta
    $resultado = $conexion->query($sql);
    //convertir resultado en un array
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
    //cerrar conexion
    $conexion = null;
    //si todo salio bien responder status ok y el resultado
    if ($resultado) {
        
        echo json_encode($resultado);

    } else {

        echo 'error';
    }
}
   if($_GET['accion'] == 'listar-inspecciones'){

        $sql = "SELECT
        tramite.ID_TRAMITE,
        tramite.NUMERO_TRAMITE,
        date_format(tramite.FECHA_TRAMITE,'%d/%m/%Y') as FECHA_TRAMITE,
        tramite.TITULAR_TRAMITE,
        matriculado.NOMBRE_MATRICULADO,
        direccion.CALLE_DIRECCION,
        direccion.NUMERO_DIRECCION,
        direccion.DEPTO_DIRECCION,
        tramite.ULTIMO_ESTADO,
        fotos.FOTO,
        Sum(IF(estado.ID_TIPO_ESTADO=2,1,0)) AS rechazos        
        FROM
        tramite
        INNER JOIN direccion ON direccion.ID_TRAMITE = tramite.ID_TRAMITE
        INNER JOIN estado ON estado.ID_TRAMITE = tramite.ID_TRAMITE
        LEFT JOIN fotos ON fotos.ID_ESTADO = estado.ID_ESTADO
        INNER JOIN matriculado ON matriculado.NUMERO_MATRICULA = tramite.NUMERO_MATRICULA
        WHERE
        tramite.ULTIMO_ESTADO = 1
        GROUP BY
        tramite.NUMERO_TRAMITE
        ";
        $conexion = new PDO('mysql:host=localhost;dbname=conexiones', 'root', '');
        
        $resultado = $conexion->query($sql);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        if ($resultado) {
            echo json_encode($resultado);
        } else {
            echo 'error';
        }


    }
}

?>
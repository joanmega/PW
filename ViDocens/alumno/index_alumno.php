<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<link rel="stylesheet" href="../estilos/estilo_video.css" type="text/css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Web del Alumno - Principal</title>
    </head>
    <body>
    	
        <?php
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==2){
		?>
    	<div id="contenedor">
        	<div id="cabecera">
            	<h1>Bienvenido, Alumno/a</h1>
              
            </div>        	        	
            <div id="menu">
            	<ul>
                	<li><a href="./index_alumno.php">Inicio</a></li>
                	<li><a href="./cursos/consultarCurso.php">Cursos</a></li>
                    <li><a href="./material/consultarMaterial.php">Material</a></li>
                	<li><a href="./alumno/consultarAlumno.php">Mis datos</a></li>
                    <li><a href="../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div>
        	<div id="cuerpo">
            	<div id="lat_izquierdo">
                </div>
                <div id="contenido">
				</div>
                <div id="lat_derecho">
                </div>
            </div>
			<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y"); ?>
            </div>
			<?php
				}else{ echo "No tiene privilegios para acceder a esta información <br>";}
			?>
        </div>
	</body>
</html>
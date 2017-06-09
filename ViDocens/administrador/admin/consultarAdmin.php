<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Administrador</title>
    </head>
    <body>
		<?php
			if ($_SESSION['tipoUsuario']==0){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, administrador</h1>
            </div>        	        	
            <div id="menu">
	       		<ul>
                	<li><a href="../index_admin.php">Inicio</a></li>
                	<li><a href="../profesores/consultarProfesores.php">Profesores</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                	<li><a href="../alumnos/consultarAlumno.php">Alumnos</a></li>
                	<li><a href="../material/altaMaterial.php">Material</a></li>
                	<li><a href="../BD/consultarCopias.php">Base de Datos</a></li>
                	<li><a href="../admin/consultarAdmin.php">Mis Datos</a></li>
					<li><a href="../../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div> 
            <div id="cuerpo">
                <div id="lat_izquierdo">
                    <ul>
                      <li><a href="../admin/consultarAdmin.php">Consultar mis datos</a></li>
                      <li><a href="../admin/modificarAdmin.php">Modificar mis datos</a></li>
                    </ul>
                </div>
                <div id="contenido">
					<?php
						include("../../conexion.php");	
					?>
                    <fieldset>
                        <legend>Lista de Alumnos</legend>
                       
						<?php
							
									$sentencia = 'SELECT * FROM usuario WHERE cod_usuario = "' .$_SESSION['Usuario']. '";';		
									$resultado = mysql_query($sentencia, $conexion)
										or die ("El usuario no se ha obtenido correctamente <br>");
									while ($fila = mysql_fetch_array($resultado)){
						?>
								<table class="tablaConsultas">
									<tr>
										<td><span>DNI:</span> <?php echo $fila['DNI']; ?></td>
										<td><span>Nombre:</span> <?php echo $fila['nombre']; ?></td>
										<td><span>Apellido 1&deg;:</span> <?php echo $fila['apellido1']; ?></td>
										<td><span>Apellido 2&deg;:</span> <?php echo $fila['apellido2']; ?></td>
									</tr>
									<tr>
										<td><span>Tel&eacute;fono:</span> <?php echo $fila['telefono']; ?></td>
										<td><span>M&oacute;vil:</span> <?php echo $fila['movil']; ?></td>
										<td><span>Correo Electr&oacute;nico:</span> <?php echo $fila['correoElectronico']; ?></td>
										<td><span>Fecha Nac:</span> <?php echo date("d/m/Y", strtotime($fila['fecNacimiento'])); ?></td>
									</tr>
									<tr>
										<td colspan="2"><span>Domicilio:</span> <?php echo $fila['domicilio']; ?></td>
										<td><span>Pa&iacute;s: </span>
											<?php if ($fila['pais']==1) echo "Espa&ntilde;a";
												if ($fila['pais']==2) echo "Portugal";
												if ($fila['pais']==3) echo "Francia";
												if ($fila['pais']==4) echo "Alemania";
												if ($fila['pais']==5) echo "Italia";
												if ($fila['pais']==6) echo "Luxemburgo";
												if ($fila['pais']==7) echo "Andorra";
												if ($fila['pais']==8) echo "B&eacute;lgica";
												if ($fila['pais']==9) echo "Inglaterra";
												if ($fila['pais']==10)echo "Noruega";
												if ($fila['pais']==11)echo "Otro pa&iacute;s"; 
											?>
										</td>
										<td><span>Usuario/Login:</span> <?php echo $fila['usuario']; ?></td>
									</tr>
								</table>
						<?php
							}
						?>
                    </fieldset>               	
                </div>
                <div id="lat_derecho"></div>
            </div>
          	<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y"); ?>
			</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
		?>
    </body>
</html>
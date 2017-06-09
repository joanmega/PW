<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Alumnos</title>
        <script type="text/javascript" src="../../javascript/ejercicio_video.js"></script>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	</head>
    <body>
		<?php
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==0){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, administrador.</h1>
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
						<li><a href="./altaMaterial.php">A&ntilde;adir Material</a></li>
						<li><a href="./bajaMaterialCurso.php">Eliminar Material</a></li>
						<li><a href="./consultarMaterial.php">Consultar Material</a></li>
						<li><a href="./modificarMaterial.php">Modificar Material</a></li>
						<li><a href="./VerMaterial.php">Ver Material por Curso</a></li>
					</ul>
                </div>
                <div id="contenido">
                    <fieldset>
                        <legend>Datos del Alumno</legend>
				<?php
										
					// Establecemos la conexión con la base de datos
					include("../../conexion.php");
				?>
				
                        <form id="verMaterial" method="post" name="verMaterial" action="verMaterial.php">
							<?php
								$sentencia = 'SELECT c.* 
									FROM Curso c, material m
									WHERE c.cod_curso=m.cod_curso
									GROUP BY c.Cod_Curso;';
								$resultado = mysql_query($sentencia, $conexion);
							?>    
							Curso: 
							<select name="tCurso">
							<?php
								while ($fila = mysql_fetch_array($resultado)){
							?>
								<option value="<?php echo $fila['Cod_Curso']; ?>"><?php echo $fila['Nombre']. " - " . $fila['Descripcion']; ?></option>
							<?php
								}
							?>
							</select>
							<input type="submit" name="bBuscar" value="Buscar" />
                        </form>
                    </fieldset>
					<?php
						if (isset($_GET['Video'])){
					?>	
					<video id="reproductor" preload="auto" controls="controls" autoplay="autoplay" poster="../../img/viDocens_logo_WP.png">
						<source src="<?php echo $_GET['Video']; ?>" data-quality="hd" type="video/mp4" title="<?php echo $_GET['Nombre'];?>">
						<!-- Para los navegadores viejos lo abrimos con flash -->
						<object>
							<embed src="<?php echo $_GET['Video']; ?>" type= "application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="always" />
					   </object>
					</video>
					<?php	
						}
					?>         	
                </div>
                <div id="lat_derecho">
					<?php
						if (isset($_REQUEST['bBuscar']) || isset($_GET['Video'])){
							if (isset($_REQUEST['tCurso'])){
								// Seleccionamos los videos que pertenecen a ese curso.
								$sentencia = 'SELECT *, c.descripcion as "DesCurso", m.descripcion as "DesMaterial" 
										FROM material m, curso c
										WHERE m.Cod_Curso = '.$_REQUEST['tCurso'] .' 
											and c.Cod_curso = m.cod_curso';
							}else{
								if (isset($_GET['Curso'])){
									$sentencia = 'SELECT *, c.descripcion as "DesCurso" , m.descripcion as "DesMaterial" 
										FROM material m, curso c
										WHERE m.Cod_Curso = '.$_GET['Curso'] .' 
											and c.Cod_curso = m.cod_curso';
								}
							}
							// Ejecutamos la sentencia y recogemos el resultado.
							$resultado = mysql_query($sentencia, $conexion);
							$resultado2 = mysql_query($sentencia, $conexion);
							$fila = mysql_fetch_array($resultado2);
						?>
						<h4><?php echo $fila['Nombre'] . ' - ' . $fila['DesCurso'] . '<br>'; ?></h4>
						<ul>
						<?php
							// Mientras tenga videos los cargamos en el lateral derecho.
							while ($fila = mysql_fetch_array($resultado)){
						?>
						<li><a href="./verMaterial.php?Video=<?php echo $fila['RutaFichero'];?>&Curso=<?php echo $fila['Cod_Curso']; ?>&Nombre=<?php echo $fila['DesMaterial']; ?>" ><?php echo $fila['DesMaterial']; ?></a></li>
						<?php
							}
						}
					?>
					</ul>
                </div>
            </div>
          	<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y");
					mysql_close($conexion); ?>
        	</div>
        </div>
		<?php
			}else{ echo "No tiene privilegios para acceder a esta información <br>";}
		?>
    </body>
</html>
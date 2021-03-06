<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="../../estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Profesores</title>
        <script type="text/javascript" src="../../javascript/ejercicio_video.js"></script>
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
						<li><a href="./altaProfesor.php">A&ntilde;adir Profesor</a></li>
						<li><a href="./eliminarProfesor.php">Eliminar Profesor</a></li>
						<li><a href="./consultarProfesores.php">Consultar Profesor</a></li>
						<li><a href="./modificarProfesor.php">Modificar Profesor</a></li>
						<li><a href="./listarProfesorCursos.php">Listar Cursos por Profesor</a></li>
						<li><a href="./altaProfesorCurso.php">A&ntilde;adir Profesor a Curso</a></li>
						<li><a href="./bajaProfesorCurso.php">Baja Profesor de curso</a></li>
					</ul>
                </div>
                <div id="contenido">
					<?php
						
					// Establecemos la conexión con la base de datos
					include("../../conexion.php");
							
					?>
                    <fieldset>
                        <legend>Lista de Profesores</legend>
                        <form id="consultarProfesor" method="post" name="consultarProfesor" action="consultarProfesores.php"> 
                            <table>
                                <tr>
                                    <td><label>Nombre</label></td>
                                    <td>
                                    <select name="tLista">
                                    	<option value="0">Todos</option>
										<?php
											$sentencia = 'SELECT cod_usuario, dni, nombre, apellido1, apellido2 
											FROM usuario 
											WHERE tipoUsuario = 1';
											
											$resultado = mysql_query($sentencia, $conexion);
											while ($fila = mysql_fetch_array($resultado)){
										?>
										<option value="<?php echo $fila['cod_usuario'];?>"><?php echo $fila['dni'] . " - " . $fila['apellido1'] . " " . $fila['apellido2'] . ", " . $fila['nombre'];?></option>
										<?php
											}
										?>
                                  </select></td>
                                	<td>
                                    	<input type="submit" name="bBuscar" value="Buscar"/>
                                   	</td>
                                </tr>
                            </table>
                        </form>
						<?php
							if (isset($_REQUEST['bBuscar'])){
								// Si lo que queremos es visualizar todos
								if ($_REQUEST['tLista'] == 0){
									$sentencia = 'SELECT u.*, p.extension, p.departamento 
									FROM usuario u, profesor p 
									WHERE tipoUsuario = 1 
										and p.cod_profesor = u.cod_usuario 
									ORDER BY apellido1, apellido2, nombre, dni;';		
								}else{
									$sentencia = 'SELECT u.*, p.extension, p.departamento 
									FROM usuario u, profesor p 
									WHERE cod_usuario = "' .$_REQUEST['tLista']. '" 
										and p.cod_profesor = u.cod_usuario 
										and tipoUsuario = 1 
									ORDER BY apellido1, apellido2, nombre, dni;';		
								}
									$resultado = mysql_query($sentencia, $conexion);
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
										<td><span>Extensi&oacute;n:</span> <?php echo $fila['extension']; ?></td>
										<td><span>Departamento:</span> <?php echo $fila['departamento']; ?></td>
									</tr>
									<tr>
										<td><span>Correo Electr&oacute;nico:</span> <?php echo $fila['correoElectronico']; ?></td>
										<td><span>Fecha Nac:</span> <?php echo date("d/m/Y", strtotime($fila['fecNacimiento'])); ?></td>
										<td colspan="2"><span>Domicilio:</span> <?php echo $fila['domicilio']; ?></td>
									</tr>
									<tr>
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
							}
						?>
                    </fieldset>               	
                </div>
                <div id="lat_derecho"></div>
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
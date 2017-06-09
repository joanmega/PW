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
                	<li><a href="../index_alumno.php">Inicio</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                    <li><a href="../material/consultarMaterial.php">Material</a></li>
                	<li><a href="../alumno/consultarAlumno.php">Mis datos</a></li>
                  <li><a href="../../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div> 
            <div id="cuerpo">
                <div id="lat_izquierdo">
                   <ul>
                      <li><a href="./consultarAlumno.php">Consultar mis datos</a></li>
                      <li><a href="./modificarAlumno.php">Modificar mis datos</a></li>
                      <li><a href="./bajaAlumno.php">Cerrar cuenta</a></li>
                   </ul>
                </div>
                <div id="contenido">
                    <fieldset>
                        <legend>Datos del Alumno</legend>
						<?php
							// Conectamos con la base de datos
							include("../../conexion.php");
							
							// Si hemos enviado el formulario realizamos la baja del alumno.
							if (isset($_REQUEST['bAceptar']) && $_REQUEST['tContrasena']!=''){
								$sentencia = 'SELECT contrasena 
									from usuario 
									where cod_usuario ='.$_SESSION['Usuario'];
								$resultado = mysql_query($sentencia, $conexion);
								$fila = mysql_fetch_array($resultado);
								if (md5($_REQUEST['tContrasena'])==$fila['contrasena']){
									$sentencia ='DELETE FROM usuario 
										WHERE cod_usuario='.$_SESSION['Usuario'];
									if (mysql_query($sentencia, $conexion)){
										echo "Has sido dado de baja del sistema correctamente. <br>En 5 segundos será redirigido a la página principal <br>";
										unset($_SESSION['Usuario']);
										unset($_REQUEST['bAceptar']);
										echo '<script language="javascript">
												setTimeout(function() {window.location="../../index_video.html"}, 5000);
											</script>';		
										//; window.location="../../index_video.html";								
									}else{
										echo "No se ha podido realizar la baja correctamente. <br>";
									}
								}else{
									echo "Introduce la contraseña correctamente. <br>";
								}
							}else{
								if ((isset($_REQUEST['bAceptar']) && $_REQUEST['tContrasena']=='')){
									echo "Introduce todos los campos obligatorios. <br>";
								}
						?>
							<form method="post" name="bajaAlumno" action="./bajaAlumno.php">
								<table>
									<tr>
										<td><label>Contrase&ntilde;a *</label></td>
										<td><input type="password" name="tContrasena" size="10" maxlength="10" tabindex="14" required="required"/></td>
									</tr>    
									<tr>
										<td></td>
										<td><input type="submit" name="bAceptar" value="Darse de baja" tabindex="16" /></td>
									</tr>  
								</table>                  
							</form>
							<?php
							}
							?>
						</fieldset>               	
                </div>
                <div id="lat_derecho">
                </div>
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
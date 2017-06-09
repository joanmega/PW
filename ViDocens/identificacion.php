<?php
	setlocale(LC_ALL,"es_ES");
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="estilos/estilo_video.css" type="text/css" rel="stylesheet"/>
        <title>Identificaci&oacute;n</title>
    </head>
	<body>
        <div id="contenedor">
            <div id="cabecera_">
                <h1>Plataforma Web de Video Docencia</h1>
            </div>
            <div id="cuerpo">
                <div id="lat_izquierdo_">
                </div>
                <div id="logoInicial">
				<?php
					// Comprobamos que se ha enviado el formulario y los dos campos no están vacíos.
					if (isset($_REQUEST['bAcceder']) && ($_REQUEST['tUsuario']!='' && $_REQUEST['tPassword']!='')){
						
						// Establecemos la conexión con la base de datos
						include("./conexion.php");
						
						// Calculamos el md5 de la contraseña.
						$contrasena = md5($_REQUEST['tPassword']);
						// Realizamos la consulta para comprobar datos y obtenes los valores de las variables de sesión.
						$sentencia = 'Select usuario, contrasena, Cod_Usuario, tipoUsuario 
						FROM usuario 
						WHERE usuario = "' . $_REQUEST['tUsuario'] . '" 
							AND contrasena = "' . $contrasena . '";';
						// Ejecutamos la consulta
						
						$resultado = mysql_query($sentencia, $conexion);
						
						// Si se ha encontrado algún registro.
						if (mysql_num_rows($resultado) == 1){
							$fila = mysql_fetch_array($resultado);
							// Inicializamos las variables de sesión necesarias.
							$_SESSION['Usuario'] = $fila['Cod_Usuario'];
							$_SESSION['tipoUsuario'] = $fila['tipoUsuario'];
							
							// Si el usuario es un administrador
							if ($_SESSION['tipoUsuario']==0){
								?>
								<a href="./administrador/index_admin.php">Entrar</a>
								<?php
							}else{
								// Si el usuario es un profesor.
								if ($_SESSION['tipoUsuario']==1){
									?>
									<a href="./profesor/index_profesor.php">Entrar</a>
									<?php
									// Si el usuario es un alumno.
								}else{
									if ($_SESSION['tipoUsuario']==2){
										?>
										<a href="./alumno/index_alumno.php">Entrar</a>
										<?php
									}else{
										echo "No estás registrado";
									}								
								}
							}
						}else{
							echo "Usuario o contraseña incorrecta. </br>";
						?>
							<a href="identificacion.php">Atr&aacute;s</a>
						<?php
						}
						
					}else{
				?>
						<img src="./img/viDocens_logo_WP.png" />
						<form action="identificacion.php" method="post" name="identificacion" >
							
							<table>
								<tr>
								   <td><label>Usuario</label></td>
								   <td><input type="text" name="tUsuario" autofocus="autofocus"/></td>
								</tr>
								<tr>
									<td><label>Contrase&ntilde;a</label></td>
									<td><input type="password" name="tPassword" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="bAcceder" value="Acceder"/></td>
							</table>
						</form>
						</br>
						<a href="altaAlumno.php">Registrarse como nuevo alumno</a><br />
					<?php	
						if(isset($_SESSION['tipoUsuario'])){
							session_destroy();
						}
					}
					?>
                </div>
                <div id="lat_derecho_"></div>
            </div>
          	<div id="pie_">
                    Hoy es <?php echo strftime("%A %d de %B del %Y"); ?>
        	</div>
        </div>
    </body>
</html>
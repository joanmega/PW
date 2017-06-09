<?php
	setlocale(LC_ALL,"es_ES"); 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
	<head>
    	<link rel="stylesheet" href="./estilos/estilo_video.css" type="text/css"/>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registro de Alumno</title>
        <script type="text/javascript" src="./javascript/ejercicio_video.js"></script>
    </head>
    <body>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido</h1>
            </div>        	        	
            <div id="menu"></div> 
            <div id="cuerpo">
                <div id="lat_izquierdo_"></div>
                <div id="contenido">
                    <fieldset>
                        <legend>Datos del Alumno</legend>
				<?php
										
					// Establecemos la conexión con la base de datos
					include("./conexion.php");
							
							
					$correcto = false;
					// Si se ha enviado el formulario y todos los campos obligatorios se han rellenado.
					if (isset($_REQUEST['bAceptar']) && $_REQUEST['tDNI']!='' && $_REQUEST['tApellido1']!='' && $_REQUEST['tApellido2']!='' && $_REQUEST['tNombre']!='' && $_REQUEST['DiaNac']!=0 && $_REQUEST['MesNac']!=0 && $_REQUEST['tUsuario']!='' && $_REQUEST['tContrasena']!='' && $_REQUEST['tContrasena2']!=''){
												
						// Recogemos las variables para un menor manejo.
						
						$DNI=$_REQUEST['tDNI'];	$nombre=$_REQUEST['tNombre'];	
						$apellido1=$_REQUEST['tApellido1'];	$apellido2=$_REQUEST['tApellido2'];	
						$pais=$_REQUEST['tPais'];	$telefono=$_REQUEST['tTelefono'];
						$movil=$_REQUEST['tMovil']; $correoElectronico=$_REQUEST['tEmail'];	
						$fecNacimiento= date($_REQUEST['AnoNac']."-".$_REQUEST['MesNac']."-".$_REQUEST['DiaNac']);	
						$domicilio=$_REQUEST['tDomicilio'];	$usuario=$_REQUEST['tUsuario'];
						$contrasena=$_REQUEST['tContrasena']; $contrasena2=$_REQUEST['tContrasena2'];
						$tipoUsuario=2;
						
						// Comparamos el valor de los campos contraseña encriptados
						
						if (md5($contrasena)==md5($contrasena2)){

							// Nos aseguramos que el DNI o el usuario no se repita.
							$sentencia = 'SELECT Cod_Usuario 
								from usuario 
								where DNI = "' . $_REQUEST['tDNI'] . '" 
									OR Usuario="' . $usuario . '";';
							$resultado = mysql_query($sentencia, $conexion);
							
							// Ejecutamos la sentencia SELECT. Si no hay registros realizamos la inserción.
							if (mysql_num_rows($resultado)==0){
								$sentencia = 'insert into Usuario (DNI, nombre, apellido1, apellido2, pais, telefono, movil, correoElectronico, fecNacimiento, domicilio, usuario, contrasena, tipoUsuario) 
								values("'.$DNI.'","'.$nombre.'","'.$apellido1.'","'.$apellido2.'",'.$pais.',"'.$telefono.'","'.$movil.'","'.$correoElectronico.'","'.$fecNacimiento.'","'.$domicilio.'","'.$usuario.'","'.md5($contrasena).'",'.$tipoUsuario.');';
								
								// Si la consulta se ejecuta correctamente.
								if (mysql_query($sentencia, $conexion)){
									echo "El alta se realizó correctamente </br>";
									// Establecemos el tipo de usuario a 2 (Alumno) e iniciamos sesion
									$_SESSION['tipoUsuario']=2;
									
									// Otenemos el código de usuario para la variable de sesión del nuevo alumno
									
									$sentencia = 'select cod_usuario
										from usuario
										where DNI = "'.$DNI.'";';
										
									$resultado = mysql_query($sentencia, $conexion);
									
									$fila = mysql_fetch_array($resultado);
									
									$_SESSION['Usuario'] = $fila['cod_usuario'];
									?>
									<a href="./alumno/index_alumno.php">Entrar</a>
									<?php
									$correcto = true;
								}else{ // Si la consulta no se ha ejecutado correctamente.
									echo "No se ha podido insertar el alumno. </br>";
								}
							}else{ // Si se ha encontrado 
								echo "Asegurese que el usuario es único, el DNI sea correcto y ha introducido todos los campos obligatorios";
							}
						}else{
							echo "Las contraseñas no coinciden. </br>";
						}
					}
					if(!$correcto){
					if (isset($_REQUEST['bAceptar']) && ($_REQUEST['tDNI']=='' || $_REQUEST['tApellido1']=='' || $_REQUEST['tApellido2']=='' || $_REQUEST['tNombre']=='' || $_REQUEST['DiaNac']==0 || $_REQUEST['MesNac']==0 || $_REQUEST['tUsuario']=='' || $_REQUEST['tContrasena']=='' || $_REQUEST['tContrasena2']=='')){
						echo "Revise todos los campos obligatorios </br>";
						echo $_REQUEST['tFecha'] . '<br>';
					}
				?>
                        <form id="anadirAlumnos" method="post" name="anadirAlumnos" action="altaAlumno.php">
                            <table>
                            	<tr>
                                    <td><label>DNI / NIF*</label></td>
                                    <td><input name="tDNI" type="text" size="9" maxlength="9" tabindex="1" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tDNI']. '"'; ?> required="required" onblur="nif(tDNI);"/></td>
                                </tr>
                                <tr>
                                    <td><label>Primer Apellido *</label></td>
                                    <td><input name="tApellido1" type="text" size="20" maxlength="20" tabindex="2" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tApellido1']. '"'; ?> required="required"/></td>
                                </tr>
                                <tr>
                                    <td><label>Segundo Apellido *</label></td>
                                    <td><input name="tApellido2" type="text" size="20" maxlength="20" tabindex="3" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tApellido2']. '"'; ?> required="required"/></td>
                                </tr>
                                <tr>
                                    <td><label>Nombre *</label></td>
                                    <td><input name="tNombre" type="text" size="20" maxlength="20" tabindex="4" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tNombre']. '"'; ?> required="required"/></td>
                                </tr>
                                <tr>
                                	<td>Pa&iacute;s *</td>
                                    <td>
                                    	<select name="tPais" tabindex="5">
											<option value="1" selected="selected">Espa&ntilde;a</option>
											<option value="2" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==2) echo 'selected="selected"'; ?>>Portugal</option>
											<option value="3" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==3) echo 'selected="selected"'; ?>>Francia</option>
											<option value="4" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==4) echo 'selected="selected"'; ?>>Alemania</option>
											<option value="5" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==5) echo 'selected="selected"'; ?>>Italia</option>
											<option value="6" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==6) echo 'selected="selected"'; ?>>Luxemburgo</option>
											<option value="7" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==7) echo 'selected="selected"'; ?>>Andorra</option>
											<option value="8" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==8) echo 'selected="selected"'; ?>>B&eacute;lgica</option>
											<option value="9" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==9) echo 'selected="selected"'; ?>>Inglaterra</option>
											<option value="10" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==10) echo 'selected="selected"'; ?>>Noruega</option>
											<option value="11" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==11) echo 'selected="selected"'; ?>>Otro pa&iacute;s</option>
                                    	</select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Tel&eacute;fono</label></td>
                                    <td><input name="tTelefono" type="text" value="0" onfocus="this.value='';" onblur="validacion(tTelefono);" size="11" maxlength="11" tabindex="6" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tTelefono']. '"'; ?>/></td>
                                </tr>
                                <tr>
                                    <td><label>M&oacute;vil</label></td>
                                    <td><input name="tMovil" type="text" size="11" value="0" onfocus="this.value='';" onblur="validacion(tMovil);" maxlength="11" tabindex="7" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tMovil']. '"'; ?>/></td>
                                </tr>
                                <tr>
                                    <td><label>Email</label></td>
                                    <td><input name="tEmail" type="text" size="30" maxlength="50" tabindex="8" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tEmail']. '"'; ?> onblur="validarEmail(tEmail);"/></td>
                                </tr>
                                <tr>
                                    <td>Fecha de Nacimiento *</td>
                                    <td>
                                    	<select id="DiaNac" name="DiaNac" tabindex="10">
                                        	<option value="0">-</option>
                                        </select>
                                        <select id="MesNac" name="MesNac" onchange="adjustDateForm(this.form.DiaNac,this.form.MesNac,this.form.AnoNac)" tabindex="9">
                                        	<option value="0">-</option>
                                        	<option value="1"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==1) echo 'selected="selected"'?>>Enero</option>
                                            <option value="2"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==2) echo 'selected="selected"';?>>Febrero</option>
                                            <option value="3"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==3) echo 'selected="selected"';?>>Marzo</option>
                                            <option value="4"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==4) echo 'selected="selected"';?>>Abril</option>
                                            <option value="5"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==5) echo 'selected="selected"';?>>Mayo</option>
                                            <option value="6"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==6) echo 'selected="selected"';?>>Junio</option>
                                            <option value="7"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==7) echo 'selected="selected"';?>>Julio</option>
                                            <option value="8"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==8) echo 'selected="selected"';?>>Agosto</option>
                                            <option value="9"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==9) echo 'selected="selected"';?>>Septiembre</option>
                                            <option value="10"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==10) echo 'selected="selected"';?>>Octubre</option>
                                            <option value="11"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==11) echo 'selected="selected"';?>>Noviembre</option>
                                            <option value="12"<?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['MesNac']==12) echo 'selected="selected"';?>>Diciembre</option>
                                        </select>
                                        <select id="AnoNac" name="AnoNac" onchange="adjustDateForm(this.form.DiaNac,this.form.MesNac,this.form.AnoNac)" tabindex="11">
                                        	<option value="0" selected="selected">-</option>
                                        <?php
											for ($i=1915; $i<=date("Y")-17; $i++){
										?>
                                        	<option value="<?php echo $i;?>" <?php if(isset($_REQUEST['bAceptar']) && $_REQUEST['AnoNac']== $i) echo 'selected="selected"'; ?>><?php echo $i; ?></option>
										<?php
											}
										?>
                                        </select>
                                	</td>
                                </tr>
								<tr>
                                	<td><label>Domicilio</label></td>
                                    <td><input type="text" name="tDomicilio" size="30" maxlength="50" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tDomicilio']. '"'; ?> tabindex="12"/></td>
                                </tr>
                                <tr>
                                	<td><label>Usuario *</label></td>
                                    <td><input type="text" name="tUsuario" size="10" maxlength="10" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tUsuario']. '"'; ?> tabindex="13" required="required"/></td>
                                </tr>      
								<tr>
                                	<td><label>Contrase&ntilde;a *</label></td>
                                    <td><input type="password" name="tContrasena" size="10" maxlength="10" tabindex="14" required="required"/></td>
                                </tr>    
								<tr>
                                	<td><label>Repita Contrase&ntilde;a *</label></td>
                                    <td><input type="password" name="tContrasena2" size="10" maxlength="10" tabindex="15" required="required"/></td>
                                </tr>                                
								<tr>
                                    <td>&nbsp;</td>
                                	<td><input type="submit" name="bAceptar" value="Aceptar" tabindex="16" />                                		<input type="reset" name="tReset" value="Limpiar Formulario" tabindex="17"/></td>
                                </tr>  
                            </table>                  
                        </form>
						<?php
						}
						?>
                    </fieldset>
                </div>
                <div id="lat_derecho_">
                </div>
            </div>
          	<div id="pie">
                    Hoy es <?php echo strftime("%A %d de %B del %Y");
					mysql_close($conexion); ?>
        	</div>
        </div>
    </body>
</html>
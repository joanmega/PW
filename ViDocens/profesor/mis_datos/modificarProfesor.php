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
			if (isset($_SESSION['tipoUsuario'])&& $_SESSION['tipoUsuario']==1){
		?>
        <div id="contenedor">
            <div id="cabecera">
                <h1>Bienvenido, Profesor/a</h1>
            </div>        	         	
            <div id="menu">
	       		<ul>	
                	<li><a href="../index_profesor.php">Inicio</a></li>
                	<li><a href="../cursos/consultarCurso.php">Cursos</a></li>
                	<li><a href="../alumnos/consultarAlumno.php">Alumnos</a></li>
                	<li><a href="../material/altaMaterial.php">Material</a></li>
                    <li><a href="../mis_datos/consultarProfesor.php">Mis datos</a></li>
                    <li><a href="../../identificacion.php">Cerrar Sesi&oacute;n</a></li>
                </ul>
            </div> 
            <div id="cuerpo">
                <div id="lat_izquierdo">
                    <ul>
                     <li><a href="./consultarProfesor.php">Consultar mis datos</a></li>
                     </li><a href="./modificarProfesor.php">Modificar mis datos</a></li>
                     
                   </ul>
                </div>
                <div id="contenido">
                    <fieldset>
                        <legend>Mis datos</legend>
						<?php
							// Conectamos con la base de datos
						// Establecemos la conexion
						include("../../conexion.php");
							
							// Si se ha enviado el formulario de modificar hacemos los cambios en la base de datos
							// y se han rellenado todos los campos obligatorios.
							if (isset($_REQUEST['bAceptar']) && $_REQUEST['tDNI']!='' && $_REQUEST['tApellido1']!='' && $_REQUEST['tApellido2']!='' && $_REQUEST['tNombre']!='' && $_REQUEST['DiaNac']!=0 && $_REQUEST['MesNac']!=0 && $_REQUEST['tUsuario']!='' && $_REQUEST['tContrasena']!='' && $_REQUEST['tContrasena2']!=''){
								
								$DNI=$_REQUEST['tDNI'];
								$pais=$_REQUEST['tPais'];	$telefono=$_REQUEST['tTelefono'];
								$movil=$_REQUEST['tMovil']; $correoElectronico=$_REQUEST['tEmail'];	
								$fecNacimiento= date($_REQUEST['AnoNac']."-".$_REQUEST['MesNac']."-".$_REQUEST['DiaNac']);	
								$domicilio=$_REQUEST['tDomicilio'];	$usuario=$_REQUEST['tUsuario'];
								$contrasena=$_REQUEST['tContrasena']; $contrasena2=$_REQUEST['tContrasena2'];
														
								//Realizamos la consulta de modificación.
								$sentencia = 'update Usuario set pais="'.$pais.'", telefono="'.$telefono.'", movil="'.$movil.'", correoElectronico="'.$correoElectronico.'", fecNacimiento="'.$fecNacimiento.'", domicilio="'.$domicilio.'", usuario="'.$usuario.'", contrasena="'.md5($contrasena).'" where DNI="'.$DNI.'";';
								
								// Ejecutamos la sentencia y liberamos la variable de aceptación del segundo formulario.
								if (mysql_query($sentencia, $conexion)){
									echo "La modificación se realizó correctamente.";
								}else{
									echo "La modificación se no realizó correctamente.";
								}
								
							}else{ // Si no
							
									// Si el formulario no se ha enviado con todos los campos obligatorios.					
									if (isset($_REQUEST['bAceptar']) && ($_REQUEST['tDNI']=='' || $_REQUEST['tApellido1']=='' || $_REQUEST['tApellido2']=='' || $_REQUEST['tNombre']=='' || $_REQUEST['DiaNac']==0 || $_REQUEST['MesNac']==0 || $_REQUEST['tUsuario']=='' || $_REQUEST['tContrasena']=='' || $_REQUEST['tContrasena2']=='')){
						echo "Revise todos los campos obligatorios </br>";
					}
						$sentencia='select * from usuario where cod_usuario='.$_SESSION['Usuario'].';';
						$resultado= mysql_query($sentencia,$conexion)
							or die (" La consulta no se ha realizado correctamente");
						$fila= mysql_fetch_array($resultado);
						?>
							<form id="modificarProfesor" method="post" name="modificarProfesor" action="./modificarProfesor.php">
								<table>
									<tr>
										<td><label>DNI / NIF</label></td>
										<td><input name="tDNI" type="text" size="9" maxlength="9" tabindex="1" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tDNI']. '"'; else echo 'value="'.$fila['DNI']. '"'; ?> readonly="readonly"/></td>
									</tr>
									<tr>
										<td><label>Primer Apellido</label></td>
										<td><input name="tApellido1" type="text" size="20" maxlength="20" tabindex="2" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tApellido1']. '"'; else echo 'value="'.$fila['apellido1']. '"';?> readonly="readonly"/></td>
									</tr>
									<tr>
										<td><label>Segundo Apellido</label></td>
										<td><input name="tApellido2" type="text" size="20" maxlength="20" tabindex="3" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tApellido2']. '"'; else echo 'value="'.$fila['apellido2']. '"';?> readonly="readonly"/></td>
									</tr>
									<tr>
										<td><label>Nombre</label></td>
										<td><input name="tNombre" type="text" size="20" maxlength="20" tabindex="4" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tNombre']. '"'; else echo 'value="'.$fila['nombre']. '"';?> readonly="readonly"/></td>
									</tr>
									<tr>
										<td>Pa&iacute;s *</td>
										<td>
											<select name="tPais" tabindex="5">
												<option value="1" selected="selected">Espa&ntilde;a</option>
												<option value="2" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==2){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==2){
														echo 'selected="selected"';
													}
												?>
												>Portugal</option>
												<option value="3" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==3){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==3){
														echo 'selected="selected"';
													}
												?>
												>Francia</option>
												<option value="4" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==4){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==4){
														echo 'selected="selected"';
													}
												?>
												>Alemania</option>
												<option value="5" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==5){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==5){
														echo 'selected="selected"';
													}
												?>
												>Italia</option>
												<option value="6" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==6){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==6){
														echo 'selected="selected"';
													}
												?>
												>Luxemburgo</option>
												<option value="7" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==7){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==7){
														echo 'selected="selected"';
													}
												?>
												>Andorra</option>
												<option value="8" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==8){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==8){
														echo 'selected="selected"';
													}
												?>
												>B&eacute;lgica</option>
												<option value="9" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==9){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==9){
														echo 'selected="selected"';
													}
												?>
												>Inglaterra</option>
												<option value="10" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==10){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==10){
														echo 'selected="selected"';
													}
												?>
												>Noruega</option>
												<option value="11" 
												<?php 
													if (isset($_REQUEST['bBuscar']) && $fila['pais']==11){
														echo 'selected="selected"';
													}elseif(isset($_REQUEST['bAceptar']) && $_REQUEST['tPais']==11){
														echo 'selected="selected"';
													}
												?>
												>Otro pa&iacute;s</option>
											</select>
										</td>
									</tr>
									<tr>
										<td><label>Tel&eacute;fono</label></td>
										<td><input name="tTelefono" type="text" onblur="validacion(tTelefono);" size="11" maxlength="11" tabindex="6" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tTelefono']. '"'; else echo 'value="'.$fila['telefono']. '"';?>/></td>
									</tr>
									<tr>
										<td><label>M&oacute;vil</label></td>
										<td><input name="tMovil" type="text" size="11" onblur="validacion(tMovil);" maxlength="11" tabindex="7" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tMovil']. '"'; else echo 'value="'.$fila['movil']. '"';?>/></td>
									</tr>
									<tr>
										<td><label>Email</label></td>
										<td><input name="tEmail" type="text" size="30" maxlength="50" tabindex="8" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tEmail']. '"'; else echo 'value="'.$fila['correoElectronico']. '"';?>/></td>
									</tr>
									<tr>
										<td>Fecha de Nacimiento *</td>
										<td>
											<select id="DiaNac" name="DiaNac" tabindex="10">
												<option value="0">-</option>
											</select>
											<select id="MesNac" name="MesNac" onchange="adjustDateForm(this.form.DiaNac,this.form.MesNac,this.form.AnoNac)" tabindex="9">
												<option value="0" >-</option>
												<option value="1" selected="selected">Enero</option>
												<option value="2">Febrero</option>
												<option value="3">Marzo</option>
												<option value="4">Abril</option>
												<option value="5">Mayo</option>
												<option value="6">Junio</option>
												<option value="7">Julio</option>
												<option value="8">Agosto</option>
												<option value="9">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
											<select id="AnoNac" name="AnoNac" onchange="adjustDateForm(this.form.DiaNac,this.form.MesNac,this.form.AnoNac)" tabindex="11">
												<option value="0" selected="selected">-</option>
											<?php
												for ($i=1915; $i<=date("Y")-17; $i++){
											?>
												<option value="<?php echo $i;?>"><?php echo $i; ?></option>
											<?php
												}
											?>
											</select>
										</td>
									</tr>
									<tr>
										<td><label>Domicilio</label></td>
										<td><input type="text" name="tDomicilio" size="30" maxlength="50" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tDomicilio']. '"'; else echo 'value="'.$fila['domicilio']. '"'; ?> tabindex="12"/></td>
									</tr>
									<tr>
										<td><label>Usuario *</label></td>
										<td><input type="text" name="tUsuario" size="10" maxlength="10" <?php if(isset($_REQUEST['bAceptar'])) echo 'value="'.$_REQUEST['tUsuario']. '"'; else echo 'value="'.$fila['usuario']. '"'; ?> tabindex="13" /></td>
									</tr>      
									<tr>
										<td><label>Contrase&ntilde;a *</label></td>
										<td><input type="password" name="tContrasena" size="10" maxlength="10" tabindex="14"/></td>
									</tr>    
									<tr>
										<td><label>Repita Contrase&ntilde;a *</label></td>
										<td><input type="password" name="tContrasena2" size="10" maxlength="10" tabindex="15"/></td>
									</tr>                                
									<tr>
										<td></td>
										<td><input type="submit" name="bAceptar" value="Aceptar" tabindex="16" />                                		<input type="reset" name="tReset" value="Limpiar Formulario" tabindex="17"/></td>
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
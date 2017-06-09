<?php
	// Hacemos la conexión a la base de datos en localhost.
	// Usuario: ejercicio_video
	// Contraseña: pass_ejercicio_video
	$conexion = mysql_connect("localhost", "ejercicio_pw", "pass_ejercicio_pw")
		or die ("No se ha podido establecer la conexión con la base de datos");
	
	// Seleccionamos la base de datos.
	// Nombre de la base de datos: vidocens
	$bd = mysql_select_db("vidocens", $conexion)
		or die ("No se ha podido seleccionar la base de datos");

// Función que crea la copia de seguridad de la base de datos en un archivo .sql

function CrearCopiaSeguridad($fecha, $directorio){
	
	// Si el directorio no existe lo creamos y le damos todos los permisos.
	if (!file_exists($directorio)){
		mkdir($directorio,0777);
	}else{
		chmod($directorio, 0777);
	}
	
	// Establecemos que seleccione todas las tablas de la BD
	$tablas = '*';
	$archivo = '';
	
   //Obtenemos todas las tablas de la base de datos
   if($tablas == '*')
   {
      $tablas = array();
      $resultado = mysql_query('SHOW TABLES');
	  // Guardamos las tablas en un array para obtener después sus datos.
      while($fila = mysql_fetch_row($resultado))
      {
         $tablas[] = $fila[0];
      }
   }
   else
   {
      $tablas = is_array($tablas) ? $tablas : explode(',',$tablas);
   }
   
   //Borramos las base de datos si existe y la volvemos a crear.
   
   $archivo .= 'DROP DATABASE IF EXISTS vidocens;';
   $archivo .= "\n";
   $archivo .= 'CREATE DATABASE vidocens;';
   $archivo .= "\n";
   $archivo .= 'USE vidocens;';
   $archivo .= "\n\n";
   
   // Desactivamos temporalmente la restricciones de claves foráneas para introducir datos en tablas con referencias a otras que aún no se hayan creado.
   $archivo .= 'SET FOREIGN_KEY_CHECKS=0;';
   $archivo .= "\n\n";
   
   // Por cada tabla que hay en nuestra BD obtenemos todos sus datos.
   foreach($tablas as $tabla)
   {
	   // Almacenamos todos los datos de la tabla.
      $resultado = mysql_query('SELECT * FROM '.$tabla);
	  // Almacenamos el numero de columnas.
      $num_colum = mysql_num_fields($resultado);
      
	  // Borramos la tabla si existe y la volvemos a crear
      $archivo.= 'DROP TABLE IF EXISTS '.$tabla.';';
	  
	  // Copiamos todo el create table por filas y lo añadimos a lo que llevamos realizado de archivo de Backup
      $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$tabla));
      $archivo.= "\n\n".$row2[1].";\n\n";
      
	  // Recorremos todos los campos de izquierda a derecha (primer campo al último) y de arriba a abajo (primer registro al último) y lo vamos añadiendo a lo que llevamos de archivo.
    for ($i = 0; $i < $num_colum; $i++)
      {
         while($fila = mysql_fetch_row($resultado))
         {
            $archivo.= 'INSERT INTO '.$tabla.' VALUES(';
            for($j=0; $j<$num_colum; $j++) 
            {
               $fila[$j] = addslashes($fila[$j]);
               $fila[$j] = ereg_replace("\n","\\n",$fila[$j]);
               if (isset($fila[$j])) { $archivo.= '"'.$fila[$j].'"' ; } else { $archivo.= '""'; }
               if ($j<($num_colum-1)) { $archivo.= ','; }
            }
            $archivo.= ");\n";
         }
      }
      $archivo.="\n\n\n";
   }
   
   // Volvemos a activar el uso de restricciones de claves foráneas.
   $archivo .= 'SET FOREIGN_KEY_CHECKS=1;';
   $archivo .= "\n\n";
   
   // Guardamos el archivo con todo el contenido en el directorio y con el nombre que queremos.
   $handle = fopen($directorio.'/'.$fecha.'.sql','w+');
   fwrite($handle,$archivo);
   fclose($handle);
}

function RestaurarBD($ruta){
	// Linea temporal
	$templine = '';
		
	// Leemos el archivo entero
	$lineas = fopen($ruta,'r');
	// Leemos cada archivo
	
	while(!feof($lineas)){
		
		$line = fgetss($lineas, 4096);
		// Si nuestra archivo es un comentario lo ignoramos.
		if (substr($line, 0, 2) == '--' || $line == ''){
			continue;
		}
		
		// Añadimos una archivo a nuestra archivo temporal
		$templine .= $line;
		
		// Si encontramos un ';' ejecutamos nuestra sentencia $templine
		if (substr(trim($line), -1, 1) == ';'){
			mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			// Ponemos de nuevo la archivo temporal a vacío
			$templine = '';
		}
	}
}

?>
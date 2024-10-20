<?php
/**  
* Programa para el manejo de gestión documental, oficios, memorandos, circulares, acuerdos
* Desarrollado y modificado por la SubSecretaría de Informática del Ecuador
* Quipux    www.gestiondocumental.gov.ec
*------------------------------------------------------------------------------
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published
* by the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program. If not, see http://www.gnu.org/licenses.
*------------------------------------------------------------------------------
**/

// Verificación de rutas para el archivo de configuración
if (is_file("./config.php")) $ruta_raiz = ".";
elseif (is_file("../config.php")) $ruta_raiz = "..";
elseif (is_file("../../config.php")) $ruta_raiz = "../..";
else die ("Su sesión ha expirado o ha ingresado en otro equipo");

// Incluir los archivos de configuración y funciones
include "$ruta_raiz/config.php";
include_once "$ruta_raiz/funciones_interfaz.php";

// Mensaje de error cuando la sesión ha expirado
$mensaje = "Su sesión ha expirado o ha ingresado en otro equipo <br><br>
            Para ingresar, haga click &nbsp<a href='$nombre_servidor/login.php' target='_parent' class='aqui'>&quot;AQUÍ&quot;</a><br>";

// Mostrar el mensaje de error en formato HTML
echo html_error($mensaje);
?>

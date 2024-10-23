<?php
/**  
 * Programa para el manejo de gestión documental, oficios, memorandos, circulares, acuerdos
 * Desarrollado y en otros Modificado por la SubSecretaría de Informática del Ecuador
 * Quipux www.gestiondocumental.gov.ec
 *------------------------------------------------------------------------------
 * Este programa es software libre: puedes redistribuirlo y/o modificarlo
 * bajo los términos de la Licencia Pública General Affero GNU según la
 * publicada por la Free Software Foundation, ya sea la versión 3 de la
 * Licencia, o (a tu elección) cualquier versión posterior.
 * Este programa se distribuye con la esperanza de que sea útil,
 * pero SIN NINGUNA GARANTÍA; sin siquiera la garantía implícita de
 * COMERCIABILIDAD o ADECUACIÓN A UN PROPÓSITO PARTICULAR.  Consulta la
 * Licencia Pública General Affero GNU para más detalles.
 *
 * Deberías haber recibido una copia de la Licencia Pública General Affero GNU
 * junto con este programa. Si no, consulta http://www.gnu.org/licenses. 
 *------------------------------------------------------------------------------
**/

$ruta_raiz = ".";
$recOrfeo = "Seguridad";

// Verificar si el archivo session_orfeo.php existe antes de incluirlo
if (file_exists("$ruta_raiz/session_orfeo.php")) {
    include "$ruta_raiz/session_orfeo.php";
} else {
    error_log("El archivo session_orfeo.php no se encontró en la ruta: $ruta_raiz/session_orfeo.php");
    die("Error: Archivo de sesión no encontrado.");
}

// Verificar si el archivo securesession.class.php existe antes de requerirlo
if (file_exists("$ruta_raiz/securesession.class.php")) {
    require_once "$ruta_raiz/securesession.class.php";
} else {
    error_log("El archivo securesession.class.php no se encontró en la ruta: $ruta_raiz/securesession.class.php");
    die("Error: Archivo de clase de sesión segura no encontrado.");
}

$ss = new SecureSession();
$ss->check_browser = true;
$ss->check_ip_blocks = 2;
$ss->secure_word = 'QUIPUX_COMUNIDAD_V4';
$ss->regenerate_id = false; // Cambia a true si deseas regenerar el ID de sesión

// Verificar la sesión
if (!$ss->Check() || !isset($_SESSION['initiated']) || !$_SESSION['initiated']) {
    // Incluir la página de error si la sesión no es válida
    include "$ruta_raiz/paginaError.php";
    die();
}
?>
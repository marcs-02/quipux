<?php
/**  Programa para el manejo de gestion documental, oficios, memorandus, circulares, acuerdos
*    Desarrollado y en otros Modificado por la SubSecretaría de Informática del Ecuador
*    Quipux    www.gestiondocumental.gov.ec
*------------------------------------------------------------------------------ 
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License, as published by 
*    the Free Software Foundation, either version 3 of the License, or (at your option) 
*    any later version. This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
*    or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License 
*    for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program. If not, see http://www.gnu.org/licenses. 
*------------------------------------------------------------------------------ 
**/

$ruta_raiz = ".";
$usua_nuevo=3;
error_reporting(0);
include_once "config.php";

$txt_administrador = 0 + $_GET["txt_administrador"];
if ($activar_bloqueo_sistema and $txt_administrador != 1) {
    if (is_file("./bodega/mensaje_bloqueo_sistema.html")) {
        include_once "$ruta_raiz/funciones_interfaz.php";
        $mensaje = file_get_contents("./bodega/mensaje_bloqueo_sistema.html");
        die (html_error($mensaje));
    }
}

/**
* Verificar si el campo usuario (login) es diferente de vacio
**/
$krd = $_POST['krd'];
if ($krd) {
    // Validar si el usuario y contraseña son correctos
    include_once "$ruta_raiz/session_orfeo.php";
    
    require_once "$ruta_raiz/securesession.class.php";  // Esta clase maneja seguridad en sesiones

    // Cambios contra Session Fixation
    if (!isset($_SESSION['initiated']) && isset($_SESSION["krd"])) {
        $ss = new SecureSession();
        $ss->check_browser = true;
        $ss->check_ip_blocks = 2;
        $ss->secure_word = 'QUIPUX_COMUNIDAD_V4';
        $ss->regenerate_id = false; //true;
        $ss->Open();
        $_SESSION['initiated'] = true;
    }

    // Verificar si es usuario nuevo o no en caso de ser usuario nuevo pide cambio de contraseña.
    if($usua_nuevo==0) {
        include($ruta_raiz."/contraxx.php");
        die("");
    }
    if (isset($_SESSION["krd"])) {
        echo "<script>window.location = 'index_frames.php';</script>";
        die ("");
    }
}

include_once "funciones_interfaz.php";
// En caso de bloqueo general del sistema
$mensaje = "Estamos experimentando dificultades técnicas.<br>Por favor vuelva a intentarlo más tarde.";
$mensaje .= "<br><br>Para ir a la pantalla de ingreso, haga click&nbsp<a href=\"$ruta_raiz/login.php\" target=\"_parent\" class=\"aqui\">&quot;AQUI&quot;</a>";
// die (html_error($mensaje));
?>
<html>
    <?php echo html_head(); ?>
    <style type="text/css">
        a:link, a:visited, a:hover { color: blue; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9; /* Fondo suave */
            color: #333; /* Color de texto */
        }
        #wrapper {
            max-width: 800px; /* Ancho máximo del contenido */
            margin: 0 auto; /* Centrar */
            padding: 20px; /* Espaciado interno */
            background-color: white; /* Fondo blanco */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
            border-radius: 8px; /* Bordes redondeados */
        }
        h1, h2 {
            text-align: center; /* Centrar encabezados */
            font-size: 2rem; /* Tamaño de letra grande */
            margin-bottom: 20px; /* Espaciado inferior */
        }
        .tex_area {
            width: 100%; /* Ancho completo */
            padding: 10px; /* Espaciado interno */
            font-size: 1.2rem; /* Tamaño de letra */
            border: 1px solid #ccc; /* Borde claro */
            border-radius: 5px; /* Bordes redondeados */
        }
        .botones {
            padding: 10px 20px; /* Espaciado interno */
            font-size: 1.2rem; /* Tamaño de letra */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #2A66A1; /* Color de fondo */
            color: white; /* Color de texto */
            cursor: pointer; /* Cambiar cursor al pasar */
            transition: background-color 0.3s; /* Transición suave */
        }
        .botones:hover {
            background-color: #1e4e7a; /* Color más oscuro al pasar */
        }
        footer {
            margin-top: 20px; /* Espacio superior */
            padding: 20px; /* Espaciado interno */
            background-color: #2A66A1; /* Color de fondo */
            color: white; /* Color del texto */
            text-align: center; /* Centrar texto */
        }
    </style>

    <body class="f-default light_slate" onLoad='document.getElementById("krd").focus();'>
        <div id="wrapper">
            <?php echo html_encabezado(); ?>
            <div id="mainbody">
                <h1>Ingreso de Usuarios al Sistema</h1>
                <form name="form_login" action="" method="post" onSubmit="return validar_login();">
                    <h2>Por favor Ingrese su n&uacute;mero de C&eacute;dula y contraseña</h2>
                    <table width="100%" cellpadding="5" cellspacing="5" align="center">
                        <tr>
                            <td align="right">Cédula:</td>
                            <td><input type="text" id='krd' name="krd" class="tex_area"></td>
                        </tr>
                        <tr>
                            <td align="right">Contraseña:</td>
                            <td><input type="password" name="drd" id="drd" class="tex_area"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <a href="javascript:login_olvido_contraseña()">¿Olvidó su contraseña?</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="Submit" type="submit" class="botones" value="Ingresar">
                                <input type="reset" value="Borrar" class="botones" name="reset">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <footer>
                <p>&copy; 2024 Instituto Superior Tecnológico Particular "Bolívar Madero Vargas". Todos los derechos reservados.</p>
                <div class="footer-links">
                    <a href="#" style="color: white;">Política de Privacidad</a> |
                    <a href="#" style="color: white;">Términos de Uso</a> |
                    <a href="#" style="color: white;">Contacto</a>
                </div>
            </footer>
        </div>
    </body>
</html>

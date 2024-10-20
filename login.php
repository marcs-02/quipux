<?php
/**  Programa para el manejo de gestion documental, oficios, memorandus, circulares, acuerdos
*    Desarrollado y en otros Modificado por la SubSecretaría de Informática del Ecuador
*    Quipux    www.gestiondocumental.gov.ec
*------------------------------------------------------------------------------
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License as
*    published by the Free Software Foundation, either version 3 of the
*    License, or (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see http://www.gnu.org/licenses. 
*------------------------------------------------------------------------------
**/

$ruta_raiz = ".";
$usua_nuevo=3;
error_reporting(0);
include_once "config.php";

/*include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler($ruta_raiz);

$clave = "f6m9k3h7";
//$clave = "f6m9k3h7b2q8n7v3c0b5t8z6h9p7x3";
$sql = "update usuario set usua_pasw='".substr(md5($clave),1,26)."' where usua_cedula='0000000000'";
$db->query($sql);
$sql = "update usuarios set usua_pasw='".substr(md5($clave),1,26)."' where usua_cedula='0000000000'";
$db->query($sql);*/

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
        // Validar si el usuario y contraseña son corectos
        include_once "$ruta_raiz/session_orfeo.php";
        
        require_once "$ruta_raiz/securesession.class.php";  //Esta clase maneja seguridad en sessiones

        //Cambios contra Session Fixation
        if (!isset($_SESSION['initiated']) && isset($_SESSION["krd"]))
        {
          $ss = new SecureSession();
          $ss->check_browser = true;
          $ss->check_ip_blocks = 2;
          $ss->secure_word = 'QUIPUX_COMUNIDAD_V4';
          $ss->regenerate_id = false; //true;
          $ss->Open();
          //  session_regenerate_id();
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
    $mensaje = "Estamos experimentando dificultades t&eacute;cnicas.<br>Por favor vuelva a intentarlo m&aacute;s tarde.";
    $mensaje .= "<br><br>Para ir a la pantalla de ingreso, haga click&nbsp<a href=\"$ruta_raiz/login.php\" target=\"_parent\" class=\"aqui\">&quot;AQUI&quot;</a>";
//    die (html_error($mensaje));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo html_head(); /*Imprime el head definido para el sistema*/?>
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        #wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #mainbody {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
        }
        .login-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .botones {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .botones:hover {
            background-color: #45a049;
        }
        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }
        .forgot-password a {
            color: #1877f2;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
    <script type="text/javascript" src="<?=$ruta_raiz?>/js/md5.js"></script>
    <?php include_once "$ruta_raiz/js/ajax.js"; ?>
    <script language="JavaScript" type="text/JavaScript">
        //<!--
        var intento_login = true;
        var timerID;
        function trim(s) {
            return s = s.replace(/^\s+|\s+$/gi, '');
        }
        function login_olvido_contraseña() {
            windowprops = "top=50,left=50,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=750,height=550";
            url = '<?=$ruta_raiz?>/Administracion/usuarios/cambiar_password_olvido.php';
            ventana = window.open(url , "cambiar_password_quipux", windowprops);
            ventana.focus();
        }
       function validar_login () {
            if (!intento_login) {
                // Si ya se hizo submit bloquea el submit para que no se haga varias veces (teniendo presionada la tecla enter)
                // Ataque de negacion de servicios
                return false;
            }
            usr = trim(document.getElementById("krd").value);
            pass = trim(document.getElementById("drd").value);
            flag = true;
            if (usr.length == 0) {
                flag = false;
                document.getElementById("krd").focus();
            }
            if (pass.length == 0) {
                flag = false;
                document.getElementById("drd").focus();
            }
            if (flag) {
                intento_login = false;
                timerID = setTimeout("activar_intento_login()", 2000);
                document.form_login.action = 'login.php?acceso=login&txt_administrador=<?=$txt_administrador?>';
                document.getElementById("drd").value = MD5(document.getElementById("drd").value);
                document.form_login.submit();
            } else {
                alert('Asegúrese de ingresar su usuario y contraseña.'); //\nSi es la primera vez que ingresa al sistema, su contraseña es "123"');
            }
            return flag;
        }
        function activar_intento_login() {
            clearTimeout(timerID);
            intento_login = true;
            return;
        }
        function detectarPhone(){
            var navegador = navigator.userAgent.toLowerCase();
            if ( navigator.userAgent.match(/iPad/i) != null)//detectar ipad
              return 2;
            else{//detectar phone        
                if( navegador.search(/iphone|ipod|blackberry|android/) > -1 )
                   return 1;    
                else 
                    return 0;
            }
        }
        window.focus();
        if (window.menubar.visible || window.toolbar.visible) { // si estan activas las barras llame a index para que se bloqueen
          if (detectarPhone()==0)
            window.location="index.php";
        }
        // -->
    </script>
</head>
<body class="f-default light_slate" onLoad='document.getElementById("krd").focus();'>
    <div id="wrapper">
        <?php echo html_encabezado(); /*Imprime el encabezado del sistema*/ ?>
        <div id="mainbody">
            <div class="login-container">
                <h1>Ingreso de Usuarios al Sistema</h1>
                <?php echo html_validar_browser(); /*Valida el browser*/ ?>
                <form name="form_login" action="" method="post" onSubmit="return validar_login();">
                    <div class="form-group">
                        <label for="krd">Cédula:</label>
                        <input type="text" id='krd' name="krd" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="drd">Contraseña:</label>
                        <input type="password" name="drd" id="drd" required>
                    </div>
                    <div id="div_tipo_usuario"></div>
                    <div class="button-group">
                        <input name="Submit" type="submit" class="botones" value="Ingresar">
                        <input type="reset" value="Borrar" class="botones" name="reset">
                    </div>
                </form>
                <div class="forgot-password">
                    <a href="javascript:login_olvido_contraseña()">¿Olvidó su contraseña?</a>
                </div>
            </div>
        </div>
        <?php echo html_pie_pagina(); /*Imprime el pie de pagina del sistema*/ ?>
    </div>
</body>
</html>
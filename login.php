<?php
/**  Programa para el manejo de gestion documental, oficios, memorandus, circulares, acuerdos
*    Desarrollado y en otros Modificado por la SubSecretaría de Informática del Ecuador
*    Quipux    www.gestiondocumental.gov.ec
*------------------------------------------------------------------------------
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License, as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see http://www.gnu.org/licenses. 
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
<html>
    <?echo html_head(); /*Imprime el head definido para el sistema*/?>
    <style type="text/css">
        a:link, a:visited, a:hover {color: blue;}
        
        body {
            background-color: #f4f4f9; /* Color de fondo suave */
            font-family: 'Poppins', sans-serif; /* Fuente moderna */
        }

        #wrapper {
            margin-top: 50px; /* Espaciado superior */
        }

        h1 {
            color: #2A66A1; /* Color del título */
        }

        h2 {
            color: #333; /* Color del subtítulo */
        }

        table {
            background-color: #ffffff; /* Fondo blanco para el formulario */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            padding: 20px; /* Espaciado interno */
        }

        input.tex_area {
            width: 100%; /* Full width inputs */
            padding: 10px; /* Espaciado interno */
            border-radius: 5px; /* Bordes redondeados */
            border: 1px solid #ddd; /* Borde claro */
        }

        input[type="submit"], input[type="reset"] {
            background-color: #2A66A1; /* Color de fondo de botones */
            color: white; /* Color de texto de botones */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px 15px; /* Espaciado interno */
            cursor: pointer; /* Cursor pointer */
            transition: background-color 0.3s; /* Transición suave */
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #1a4a7d; /* Color al pasar el ratón */
        }

        a {
            color: #2A66A1; /* Color de los enlaces */
        }

        a:hover {
            text-decoration: underline; /* Subrayado al pasar el ratón */
        }
    </style>

    <script type="text/javascript" src="<?=$ruta_raiz?>/js/md5.js"></script>
    <? include_once "$ruta_raiz/js/ajax.js"; ?>
    <script language="JavaScript" type="text/JavaScript">
    <!--
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
                alert('Asegúrese de ingresar su usuario y contraseña.');
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
            if ( navigator.userAgent.match(/iPad/i) != null)
              return 2;
            else{
                if( navegador.search(/iphone|ipod|blackberry|android/) > -1 )
                   return 1;    
                else 
                    return 0;
            }
        }
        
        window.focus();
        
        if (window.menubar.visible || window.toolbar.visible) {
          if (detectarPhone()==0)
            window.location="index.php";
        }

        // -->
    </script>

    <body class="f-default light_slate" onLoad='document.getElementById("krd").focus();'>
        <div id="wrapper" class="container">
        <? echo html_encabezado(); /*Imprime el encabezado del sistema*/ ?>
        <div id="mainbody" class="text-center">
            <div class="shad-1">
                <div class="shad-2">
                    <div class="shad-3">
                        <div class="shad-4">
                            <div class="shad-5">
                                <h1>Ingreso de Usuarios al sistema</h1>
                                <hr />
                                <div class="moduletable">
                                    <table align="center" width="100%" cellpadding="0" cellspacing="0">
                                        <tr valign="top" align="center">
                                            <td class="left" align="center" width="100%">
                                                <table cellspacing="3" cellpadding="0" border="0" align="center" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td align="center" width="100%">
                                                                <? echo html_validar_browser(); /*Valida el browser*/ ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="100%" align="center">                    
                                                                <form name="form_login" action="" method="post" onSubmit="return validar_login();">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <td align="center" colspan="2">
                                                                                <h2>Por favor Ingrese su n&uacute;mero de C&eacute;dula y contraseña</h2>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right">C&eacute;dula:</td>
                                                                            <td>
                                                                                <input type="text" id='krd' name="krd" class="tex_area" maxlength="50">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right">Contrase&ntilde;a:</td>
                                                                            <td>
                                                                                <input type="password" name="drd" id="drd" class="tex_area">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div id="div_tipo_usuario"></div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="center">
                                                                                <a href="javascript:login_olvido_contraseña()">¿Olvid&oacute; su contrase&ntilde;a?</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="center">
                                                                                <br>
                                                                                <input name="Submit" type="submit" class="botones" value="Ingresar">
                                                                                &nbsp;&nbsp;
                                                                                <input type="reset" value="Borrar" class="botones" name="reset">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
             </div>
         </div>
        <br><br>
        <? echo html_pie_pagina(); /*Imprime el pie de pagina del sistema*/ ?>
        </div>
    </body>
</html>

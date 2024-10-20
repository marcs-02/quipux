<?php
    $ruta_raiz = '.';
    if (session_id() == "") {
        session_start();
    }
    if (session_id()) {
        session_destroy();
    }
?>
<html>
<head>
    <title>.:: Quipux - Sistema de Gestión Documental ::.</title>
    <link href="estilos/light_slate.css" rel="stylesheet" type="text/css">
    <link href="estilos/splitmenu.css" rel="stylesheet" type="text/css">
    <link href="estilos/template_css.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="imagenes/favicon.ico">
</head>
<body id="page-bg" class="f-default light_slate">
  <div id="wrapper">
    <div id="mainbody">
        <div class="shad-1">
            <div class="shad-2">
                <div class="shad-3">
                    <div class="shad-4">
                        <div class="shad-5">

                            <br><br><br>
                            <table align="center" width="300" height="250" border="0" class="mainbody">
                                <tr align="center" valign="top">
                                    <td>
                                        <table>
                                            <tr align="center" valign="top">
                                                <td>
                                                    <h1>Gobierno Nacional de la República del Ecuador</h1>
                                                    <h1>Sistema de Gestión Documental - QUIPUX</h1>
                                                </td>
                                            </tr>
                                            <tr align="center">
                                                <td height="150px">
                                                    <h3>
                                                        Al momento el sistema no se encuentra disponible, por favor espere un momento y vuelva a intentarlo.<br>
                                                        Click&nbsp<a href="<?=$ruta_raiz?>/login.php" target="_parent" class="aqui">"AQUI"</a>&nbsp;para volver a intentarlo.
                                                    </h3>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="center">
                                        <img src="quipux-logo1.png" height="100" width="160" alt="Quipux Logo"/>
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
</body>
</html>

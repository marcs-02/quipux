<?php
$ruta_raiz = "..";
session_start();
include_once "$ruta_raiz/rec_session.php";
include_once "$ruta_raiz/funciones_interfaz.php";
echo "<html>" . html_head();
?>

<script type="text/javascript">
    function llamaCuerpo(parametros) {
        top.frames['mainFrame'].location.href = parametros;
    }
</script>

<body>
    <center>
    <br><br>
<?php 
/**
* If the user entering the system is the super-administrator, load the combo with the list of institutions.
**/
if ($_SESSION["usua_codi"] == 0 || $_SESSION["admin_institucion"] == 1) {
    if (isset($_POST["inst_actu"])) {
        $inst_codi = (int)$_POST["inst_actu"]; // Cast to int for safety
        if ($inst_codi != 0) {
            $_SESSION["inst_codi"] = $inst_codi; // Fixed variable name
        }
    }
    $inst_actu = $_SESSION["inst_codi"] ?? 0; // Use null coalescing operator

    $sql = "SELECT inst_nombre, inst_codi FROM institucion WHERE inst_estado = 1 ORDER BY inst_nombre ASC";
    $rs = $db->conn->query($sql);
    $menu_institucion = $rs->GetMenu2("inst_actu", $inst_actu, "0:&lt;&lt seleccione &gt;&gt;", false, "", "class='select' onchange='document.formulario.submit()'");
?>
    <form name="formulario" id="formulario" method="post" action="">
        <table width="50%" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
            <tr>
                <td colspan="2" class="titulos4"><center><strong>Instituciones para Administrar</strong></center></td>
            </tr>
            <tr>
                <td align="center" class="listado2"><?= $menu_institucion ?></td>
            </tr>
        </table>
    </form>
    <br>

    <table width="50%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
        <tr>
            <td colspan="2" class="titulos4"><center><strong>Módulo de Administración</strong></center></td>
        </tr>
<?php
    $num_menu = 0;
    echo dibujar_opcion_menu("usuarios/cambiar_password.php", "Cambio de contraseña", "Opción para cambiar la contraseña del usuario actual");
    
    if ($_SESSION["tipo_usuario"] == 1) { // Check if is public official
        echo dibujar_opcion_menu("listas/listas.php", "Listas de envío", "Opción para Administrar Lista de usuarios para envío de correspondencia");

        if ($_SESSION["usua_admin_sistema"] == 1 || $_SESSION["usua_perm_ciudadano"] == 1) {
            echo dibujar_opcion_menu("ciudadanos/cuerpoUsuario_ext.php?accion=2", "Ciudadanos", "Opción para administrar Usuarios Ciudadanos");
        }

        if ($_SESSION["usua_admin_sistema"] == 1) {
            echo dibujar_opcion_menu("usuarios/mnuUsuarios.php", "Usuarios internos", "Opción para administrar Usuarios del Sistema de la Institución Actual");
            echo dibujar_opcion_menu("dependencias/mnu_dependencias.php", "Áreas", "Opción para administrar Áreas de la Institución");
            echo dibujar_opcion_menu("tbasicas/adm_instituciones.php", "Instituciones", "Opción para administrar Instituciones");            
            echo dibujar_opcion_menu("tbasicas/adm_formato_doc.php", "Numeración de documentos", "Opción para administrar la numeración de los documentos");
        }

        if ($_SESSION["usua_codi"] == 0) {
            echo dibujar_opcion_menu("$ruta_raiz/tx/revertir_firma_digital.php", "Regeneración de archivo PDF", "Revertir la firma digital en los documentos");
            echo dibujar_opcion_menu("mensajes_alerta/mensajes_alerta_menu.php", "Administrar Alertas del Sistema", "Opción para administrar alertas.");
            echo dibujar_opcion_menu("catalogos/ciudad.php", "Ciudad", "Opción para administrar las ciudades");
            echo dibujar_opcion_menu("catalogos/titulo_usuario.php", "Título Académico", "Opción para administrar los títulos académicos");
            echo dibujar_opcion_menu("catalogos/contenido.php", "Administración de Contenidos", "Opción para administrar los contenidos del sistema");
            if (date("m") == 1 && date("d") == 1) {
                echo dibujar_opcion_menu("javascript:confirmar_inicio_secuencias();", "Inicializar Secuencias para el año " . date("Y"), "Opción para inicializar secuencias al comenzar un nuevo año", true);
            }
        }

        if ($_SESSION["usua_codi"] != 0) {
            echo dibujar_opcion_menu("$ruta_raiz/backup/respaldo_menu.php", "Respaldo de Documentos", "Opción para solicitar el respaldo de documentos del usuario actual.");
        }

        if ($_SESSION["usua_admin_sistema"] == 1 || $_SESSION["usua_codi"] == 0) {
            echo dibujar_opcion_menu("$ruta_raiz/metadatos/metadatos_menu.php", "Metadatos de Documentos", "Opción para administrar metadatos.");
        }
        
        if ($_SESSION["perm_actualizar_sistema"] == 1) {
            echo dibujar_opcion_menu("archivos/archivos_menu.php", "Administrar repositorio de archivos", "Administra el repositorio para los archivos anexos y generados en Quipux");
        }       
    } // IF Si es funcionario publico

    if ($_SESSION["usua_codi"] == 0 && date("m") == 1 && date("d") == 1) { ?>
        <script type="text/javascript">
            function confirmar_inicio_secuencias() {
                var texto = prompt('Por favor ingrese el siguiente texto:\n"QuiPux 2012"');
                if (texto == 'QuiPux 2012') {
                    if (confirm('¿Seguro que desea inicializar todas las secuencias del sistema?')) {
                        window.location = 'tbasicas/cambio_de_anio.php';
                    }
                } else {
                    if (texto != null) {
                        alert('Error en el texto de validación.\nUsted ingresó la cadena: "' + texto + '"');
                    }
                }
            }
        </script>
    <?php } ?>

    </table>
</center>
</body>
</html>

<?php

function dibujar_opcion_menu($pagina, $nombre, $descripcion = "", $flag_javascript = false) {
    global $num_menu;
    $funcion = "llamaCuerpo('$pagina');";
    if ($flag_javascript) {
        $funcion = $pagina; // Direct link if JS flag is set
    }
    $texto = "<tr>
                <td class=\"listado2\">
                    <a onclick=\"$funcion\" href='javascript:void(0);' target='mainFrame' class='vinculos' title='$descripcion'>".(++$num_menu).". $nombre</a>
                </td>
              </tr>";
    return $texto;
}
?>

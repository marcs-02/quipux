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
**************************************************************************************
** Respalda uno por uno los documentos de los usuarios                              **
** Busca los documentos que se deberán respaldar y los respalda uno por uno         **
** llamando a backup_usuarios_respaldar_documentos.php utilizando Ajax              **
**                                                                                  **
** Desarrollado por:                                                                **
**      Mauricio Haro A. - mauricioharo21@gmail.com                                 **
*************************************************************************************/

$ruta_raiz = "../..";
session_start();
if($_SESSION["perm_actualizar_sistema"]!=1) die("ERROR: Usted no tiene permisos suficientes para acceder a esta p&aacute;gina.");
include_once "$ruta_raiz/rec_session.php";
if (!is_dir("$ruta_raiz/bodega/2013/reversa")) mkdir ("$ruta_raiz/bodega/2013/reversa");

include_once "$ruta_raiz/funciones_interfaz.php";
echo "<html>".html_head();
include_once "$ruta_raiz/js/ajax.js";

?>
<script type="text/javascript">

    var timer_id_archivos_revertir_modulo = 0; // Temporizador

    function fjs_play_copia() {
        document.getElementById('img_play').setAttribute('onclick', "");
        timer_id_archivos_revertir_modulo = setTimeout("fjs_ejecutar_copia()", 300);
        document.getElementById('spn_estado').innerHTML = 'Ejecutandose';
        return;
    }

    function fjs_pausar_copia() {
        document.getElementById('img_play').setAttribute('onclick', "fjs_play_copia()");
        clearTimeout(timer_id_archivos_revertir_modulo);
        document.getElementById('spn_estado').innerHTML = 'Detenido';
        return;
    }

    function fjs_ejecutar_copia() {
        nuevoAjax('div_ejecutar_copia', 'POST', 'archivos_revertir_modulo_copiar.php', '', 'fjs_play_copia()');
        return;
    }

</script>

<body>
  <center>
    <br>
    <table width="90%" align="center" class=borde_tab border="0">
        <tr>
            <th width="100%" colspan="3">
              <center>
                  <br><b>REVERTIR M&Oacute;DULO DE ARCHIVO</b><br>Copiar los archivos de la BDD al File System<br>&nbsp;
              </center>
            </th>
        </tr>
        <tr>
            <td width="10%">&nbsp;</td>
            <td width="80%" align="left">
                <br>Ejecutar proceso:<br><br>
                <center>
                    <img src="<?=$ruta_raiz?>/imagenes/play.png" id="img_play" alt="ejecutar" style="width: 20px; height: 20px;" onclick='fjs_ejecutar_copia()'>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?=$ruta_raiz?>/imagenes/pause.png" id="img_pause" alt="detener" style="width: 20px; height: 20px;" onclick='fjs_pausar_copia()'>
                </center>
                <br>
            </td>
            <td width="10%" align="right" valign="middle">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left">
                <br>Estado de la Ejecución: <b><span id="spn_estado">No iniciado</span></b><br><br>
                <div id="div_ejecutar_copia" style="width: 100%; text-align: center;"></div>
                <br>&nbsp;
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br>

    <input type="button" name="btn_cancelar" value="Cerrar" class="botones_largo" onClick="window.close();">
  </center>

</body>
</html>
<?php
?>

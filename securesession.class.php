<?php

/*
  SecureSession class
  Written by Vagharshak Tozalakyan <vagh@armdex.com>
  Released under GNU Public License
  Recomendación: Cambiar al formato de clases estándar en PHP5 con OO
*/
class SecureSession
{
    // Include browser name in fingerprint?
    public $check_browser = true;

    // How many numbers from IP use in fingerprint?
    public $check_ip_blocks = 0;

    // Control word - any word you want.
    public $secure_word = 'SECURESTAFF';

    // Regenerate session ID to prevent fixation attacks?
    public $regenerate_id = true;

    // Call this when init session.
    public function open()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Aseguramos que la sesión esté iniciada
        }
        $_SESSION['ss_fprint'] = $this->generateFingerprint();
        $this->regenerateId();
    }

    // Call this to check session.
    public function check()
    {
        $this->regenerateId();
        return (isset($_SESSION['ss_fprint']) && $_SESSION['ss_fprint'] == $this->generateFingerprint());
    }

    // Internal function. Returns MD5 from fingerprint.
    private function generateFingerprint()
    {
        $fingerprint = $this->secure_word;
        if ($this->check_browser) {
            $fingerprint .= $_SERVER['HTTP_USER_AGENT'];
        }
        if ($this->check_ip_blocks) {
            $num_blocks = abs(intval($this->check_ip_blocks));
            if ($num_blocks > 4) {
                $num_blocks = 4;
            }
            $blocks = explode('.', $_SERVER['REMOTE_ADDR']);
            for ($i = 0; $i < $num_blocks; $i++) {
                $fingerprint .= $blocks[$i] . '.';
            }
        }
        return md5($fingerprint);
    }

    // Internal function. Regenerates session ID if possible.
    private function regenerateId()
    {
        if ($this->regenerate_id && function_exists('session_regenerate_id')) {
            session_regenerate_id(true);
            $this->_actualizaSessionBD();  // Llama a función para actualizar la sesión en la base de datos
        }
    }

    /**
     * _ActualizaSessionBD Esta función actualiza la sesión en la tabla usuarios_session de quipux
     */
    private function _actualizaSessionBD()
    {
        // Grabar la sesión regenerada en una tabla
        $ruta_raiz = ".";
        require_once("$ruta_raiz/include/db/ConnectionHandler.php");
        $db = new ConnectionHandler("$ruta_raiz");
        $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        
        // Actualiza la sesión del usuario
        $nueva_session = "E'" . session_id() . "'";
        $query = "UPDATE USUARIOS_SESION SET usua_sesion=" . $nueva_session . " WHERE usua_codi ='" . $_SESSION["usua_codi"] . "'";
        $ejecuta_update = $db->query($query);
    }
}


?>

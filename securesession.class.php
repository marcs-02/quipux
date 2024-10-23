<?php

/*
  SecureSession class
  Written by Vagharshak Tozalakyan <vagh@armdex.com>
  Released under GNU Public License
  Recomendación: Cambiar al formato de clases estándar en PHP5 con OO
*/

class SecureSession
{
    // Incluir nombre del navegador en la huella digital?
    private $check_browser = true;

    // Cuántos bloques de IP usar en la huella digital?
    private $check_ip_blocks = 0;

    // Palabra de control - cualquier palabra que quieras.
    private $secure_word = 'SECURESTAFF';

    // Regenerar ID de sesión para prevenir ataques de fijación?
    private $regenerate_id = true;

    // Llamar a esto al iniciar sesión.
    public function open()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Aseguramos que la sesión esté iniciada
    }
    $_SESSION['ss_fprint'] = $this->generateFingerprint();
    $this->regenerateId();
}


    // Llamar a esto para verificar la sesión.
    public function check()
    {
        $this->regenerateId();
        return (isset($_SESSION['ss_fprint']) && $_SESSION['ss_fprint'] == $this->generateFingerprint());
    }

    // Generar huella digital.
    private function generateFingerprint()
    {
        $fingerprint = $this->secure_word;

        if ($this->check_browser) {
            $fingerprint .= $_SERVER['HTTP_USER_AGENT'];
        }

        if ($this->check_ip_blocks > 0) {
            $blocks = explode('.', $_SERVER['REMOTE_ADDR']);
            for ($i = 0; $i < min($this->check_ip_blocks, count($blocks)); $i++) {
                $fingerprint .= $blocks[$i] . '.';
            }
        }

        return md5($fingerprint);
    }

    // Regenerar ID de sesión.
    private function regenerateId()
    {
        if ($this->regenerate_id && function_exists('session_regenerate_id')) {
            session_regenerate_id(true);
            $this->updateSessionInDB();
        }
    }

    /**
     * Actualiza la sesión en la tabla USUARIOS_SESION de la base de datos.
     */
    private function updateSessionInDB()
    {
        $ruta_raiz = ".";
        require_once("$ruta_raiz/include/db/ConnectionHandler.php");
        $db = new ConnectionHandler("$ruta_raiz");
        $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

        $session_id = session_id();
        $user_code = $_SESSION["usua_codi"];

        // Consulta preparada para prevenir inyección SQL
        $query = "UPDATE USUARIOS_SESION SET usua_sesion = ? WHERE usua_codi = ?";
        $params = [$session_id, $user_code];
        
        // Ejecutar la consulta
        $result = $db->query($query, $params);

        // Manejo de errores
        if (!$result) {
            error_log('Error updating session: ' . $db->conn->ErrorMsg());
        }
    }
}

?>

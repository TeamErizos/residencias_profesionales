<?php

class User {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function login($username, $password) {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM cuenta WHERE mail_cuenta = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar la contraseña
        if (password_verify($password, $result['password_cuenta'])) {
            // Si la contraseña es correcta, retornar el registro del usuario
            return $result;
        } else {
            // Si la contraseña es incorrecta, retornar false
            return false;
        }
    }
}

?>

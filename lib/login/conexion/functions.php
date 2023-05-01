<?php

class User {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Esta función es para la tabla [cuenta]
    // Credenciales: usuario(mail_cuenta) y contraseña(password_cuenta)
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

    // Esta función es para la tabla [alumnos]
    // Credenciales: usuario(no_control) y contraseña(password_alumno)
    public function loginAlumno($username, $password) {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM alumno WHERE no_control = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar la contraseña
        if (password_verify($password, $result['password_alumno'])) {
            // Si la contraseña es correcta, retornar el registro del usuario
            return $result;
        } else {
            // Si la contraseña es incorrecta, retornar false
            return false;
        }
    }

    // Esta función es para la tabla [empresa] o Asesor Externo
    // Credenciales: usuario(rfc_empresa) y contraseña(password_empresa)
    public function loginEmpresa($username, $password) {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM empresa WHERE rfc_empresa = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar la contraseña
        if (password_verify($password, $result['password_empresa'])) {
            // Si la contraseña es correcta, retornar el registro del usuario
            return $result;
        } else {
            // Si la contraseña es incorrecta, retornar false
            return false;
        }
    }
    // Esta función es para la tabla [profesor] que puede ser [Asesor Interno] o [Coordinador]
    // Credenciales: usuario(correo_profesor) y contraseña(password_profesor)
    public function loginProfesor($username, $password) {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM profesor WHERE correo_profesor = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar la contraseña
        if (password_verify($password, $result['password_profesor'])) {
            // Si la contraseña es correcta, retornar el registro del usuario
            return $result;
        } else {
            // Si la contraseña es incorrecta, retornar false
            return false;
        }
    }    

}

?>

<?php

    function login($conn, $username, $password) {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar la contraseña
        if (password_verify($password, $result['password'])) {
            // Si la contraseña es correcta, retornar el registro del usuario
            return $result;
        } else {
            // Si la contraseña es incorrecta, retornar false
            return false;
        }
    }

?>

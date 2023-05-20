<html>
    <?php
    include("../conectAWS.php");
    $sql = "SELECT * FROM `asesorias`";
    $sql = "SELECT * FROM `asesorias`";

$query = $conn->query($sql); 
    ?>
    
    <html>
        <head>
        <title>Asesorias</title>
        </head>
        <body>
        <div class="Asesorias">
            <h2>Asesorias Registradas</h2>
            <a href='asesoria_insert.php'>Agregar Asesoria</a>
            <table border = "1">
                <thead>
                    <tr>
                        <th>ID de Asesoria</th>
                        <th>Estado de la Asesoria</th>
                        <th>Tipo de la Asesoria</th>
                        <th>Localizacion de la Asesoria</th>
                        <th>Temas a Tratar</th>
                        <th>Fecha de la Asesoria</th>
                        <th>Solucion de la Asesoria</th>
                    </tr>
                </thead>
            <tbody>
            <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <th><?= $row['ID_Asesorias'] ?></th>
            <th><?= $row['Estado_Asesorias'] ?></th>
            <th><?= $row['Tipo_Asesorias'] ?></th>
            <th><?= $row['Lugar_Asesorias'] ?></th>
            <th><?= $row['Temas_Asesorias'] ?></th>
            <th><?= $row['Fecha_Asesorias'] ?></th>
            <th><?= $row['Solucion_Asesorias'] ?></th>
    
            <?php if ($row['Estado_Asesorias'] != "Realizada"): ?>
                <th><a href="asesoria_maestros_modificacion.php?ID_Asesorias=<?= $row['ID_Asesorias'] ?>" class="Asesorias--Update">Editar</a></th>
                <th><a href="asesoria_maestros_final.php?ID_Asesorias=<?= $row['ID_Asesorias'] ?>" class="Asesorias--Update">Solucionar</a></th>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
            </tbody>
        </body>
    </html>
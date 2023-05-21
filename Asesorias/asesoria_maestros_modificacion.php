<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
  $('form').submit(function(event) {
    event.preventDefault(); // evita el envío del formulario normal
    var formData = $(this).serialize(); // convierte el formulario a una cadena de consulta
    formData += '&no_control=<?= $_GET['no_control'] ?>'; // agrega el parámetro no_control
    $.post('update_asesorias.php', formData, function(response) {
      // maneja la respuesta del servidor aquí si es necesario
      // redirige al usuario a la página asesorias_mastros_selecion.php después de enviar el formulario
      window.location.href = "asesorias_mastros_selecion.php?no_control=<?= $_GET['no_control'] ?>";
    });
  });
});
</script>

<?php 
    include("../conectAWS.php");
    
    $ID_Asesorias = $_GET['ID_Asesorias'];
    $no_control = $_GET['no_control'];

    try {
        // Crear la instancia de conexión con PDO
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $conn = new PDO($dsn, $user, $password);
        // Configurar el modo de errores de PDO para mostrar excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM asesoria WHERE id_asesoria = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id', $ID_Asesorias);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Imprimir mensaje de error
        echo "Error al conectar a la base de datos $dbname en $host: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<a href='asesorias_mastros_selecion.php?no_control=<?= $no_control ?>'>Atras</a>
    <head><title>Modificación de Asesorias</title></head>
    <body>
        <div class="Formulario_Proyectos">
            <form>
            
            <input type="hidden" name="ID_Asesorias" value="<?= $row['id_asesoria']?>">
            <input type="hidden" name="Estado_Asesorias" value="<?= $row['estado_asesoria']?>">
            <input type="hidden" name="FK_ID_P_X_A" value="<?= $row['fk_id_p_x_a']?>">
                </p>
                <p>Cambiar la Modalidad de la Asesoria
                <select name="Tipo_Asesorias" id="Tipo_Asesorias">
                    <?php if ($row['tipo_asesoria'] == 'Presencial'): ?>
                        <option value="Presencial" selected>Presencial</option>
                        <option value="Virtual">Virtual</option>
                    <?php elseif ($row['tipo_asesoria'] == 'Virtual'): ?>
                        <option value="Presencial">Presencial</option>
                        <option value="Virtual" selected>Virtual</option>
                    <?php endif; ?>
                </select>
                </p>
                    <p>Cambiar el Lugar *Si cambió la modalidad a virtual favor de borrar el lugar de la asesoria*</p>

                <p><input type="text" name="Lugar_Asesorias" value="<?= $row['lugar_asesoria']?>"></p>
                <p>Cambiar los temas a tratar en la asesoria</p>
                <textarea cols="40" rows="5" wrap="physical" name="Temas_Asesorias" id="Temas_Asesorias"><?= $row['temas_asesoria']?></textarea><br />
                <p>Cambiar la fecha de la asesoria</p>
                <input type="date" name="Fecha_Asesorias" value="<?= $row['fecha_asesoria']?>">
                <p>Cambiar el numero de la asesoria</p>
                <input type="text" name="Num_Asesoria" value="<?= $row['num_asesoria']?>">

                <p><input type="submit" value="Actualizar"></p>
            </form>
        </div>

        <script>
            $('form').submit(function(event) {
                event.preventDefault(); // evita el envío del formulario normal
                var formData = $(this).serialize(); // convierte el formulario a una cadena de consulta
                formData += '&no_control=<?= $no_control ?>'; // agrega el parámetro no_control
                $.post('update_asesorias.php', formData, function(response) {
                    // maneja la respuesta del servidor aquí si es necesario
                    // redirige al usuario a la página asesorias_mastros_selecion.php después de enviar el formulario
                    window.location.href = "asesorias_mastros_selecion.php?no_control=<?= $no_control ?>";
                });
            });
        </script>
    </body>
</html>
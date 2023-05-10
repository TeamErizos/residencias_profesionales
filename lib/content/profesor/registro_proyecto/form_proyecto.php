
<?php 

// Incluir el archivo que contiene la clase Proyecto & conexión
require 'resources/funciones_proyecto.php';
require "../../../login/conexion/conectAWS.php";


// Crear una instancia de la clase Proyecto
$proyecto = new Proyecto($conn);

// Obtener las empresas
$empresas = $proyecto->obtenerEmpresas();

// Verificar si se recibieron los datos del formulario
if (isset($_POST['nombre'])) {
    // Obtener el valor del nombre seleccionado
    $id_profesor = $_POST['nombre'];

    // Recuperar el nombre del profesor para mostrarlo
    $nombre_seleccionado = $proyecto->obtenerNombreProfesor($id_profesor);
  
    // Establecer el tiempo de vida de la cookie (en este caso, 30 días)
    $tiempo_de_vida = time() + (30 * 24 * 60 * 60);
  
    // Guardar el valor del id del profe en una cookie
    setcookie("clave_profesor", $id_profesor, $tiempo_de_vida);

    // Guardar el valor del nombre seleccionado en una cookie
    setcookie("nombre_seleccionado", $nombre_seleccionado, $tiempo_de_vida);
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device=width, initial-scale=1.0">
    <link rel="stylesheet" href="style_general_forms.css">
    <title>Formulario - Proyectos</title>
</head>

<body>

    <div class="containerForm">
        <form action="resources/insertar_proyecto.php" method="post">
            <h2>Proyectos</h2>
            <div class="content">
                
                <div class="input-box">
                    <label for="proyecto">Nombre del Proyecto:</label>
                    <input type="text" maxlength="255" placeholder="¿Cómo se llama el proyecto?" name="NombreProyecto" required>
                </div>

                <div class="input-box">
                    <label for="objetivo">Objetivo General:</label>
                    <input type="text" maxlength="255" placeholder="¿Cuál es la iniciativa?" name="ObjetivoGeneral" required>
                </div>

                <div class="input-box">
                    <label for="descProyecto">Descripción del Proyecto:</label>
                    <input type="text" maxlength="255" placeholder="¿De qué trata el proyecto?" name="DescripcionProyecto" required>
                </div>

                <div class="input-box">
                    <label for="impProyecto">Impacto del Proyecto:</label>
                    <input type="text" placeholder="¿Cuál es el resultado esperado?" name="ImpactoProyecto" maxlength="255" required>
                </div>
                
                <div class="input-box">
                    <label for="tipoProyecto">Tipo de Proyecto:</label>
                    <select name="TipoProyecto">
                        <option value="" selected hidden>Elegir</option>
                        <option>Interno</option>
                        <option>Externo</option>
                        <option>Dual</option>
                        <option>CIIE</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="opcionProyecto">Opcion de Proyecto:</label>
                    <select name="OpcionProyecto">
                        <option value="" selected hidden>Elegir</option>
                        <option>Propuesta Propia</option>
                        <option>Trabajador</option>
                        <option>Banco de Proyectos</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="numResidentes">Numero de Participantes:</label>
                    <input type="text" placeholder="Numero de residentes en el proyecto" name="NumResidentes" required>
                </div>


                <!-- Primero hay que seleccionar las carreras
                Para seleccionar al maestro -->

                
                    
                
                <div class="input-box">
                <!-- Mostrar el valor de la cookie si existe -->
                <?php if (isset($_COOKIE['nombre_seleccionado'])) { ?>
                    <label for="nombreAsesorInterno">Nombre del Asesor Interno:</label>
                    <input type="text" name="NombreAsesorInterno" value="<?php echo $_COOKIE['nombre_seleccionado'];?>"
                        disabled>    
                <?php } ?>

                </div>
                

                

                
                <div class="bottom-line">
                    <!-- HTL NUEVO, AÑADIR AL ASESESOR INTERNO DESDE AHORA -->
                
                    <h3>Datos del Asesor Externo</h3>
                    <div class="input-box">
                    <label for="nombreExterno">Nombre del Asesor Externo</label>
                    <input type="text" placeholder="requerido" name="nombreExterno" maxlength="20" required>
                </div>

                <div class="input-box">
                    <label for="ape1Externo">1er Apellido del Asesor Externo</label>
                    <input type="text" placeholder="requerido" name="ape1Externo" maxlength="20" required>
                </div>

                <div class="input-box">
                    <label for="ape2Externo">2ndo Apellido del Asesor Externo</label>
                    <input type="text" placeholder="requerido" name="ape2Externo" maxlength="20" required>
                </div>

                <div class="input-box">
                    <label for="puestoExterno">Puesto del Asesor Externo</label>
                    <input type="text" placeholder="requerido" name="puestoExterno" maxlength="20" required>
                </div>

                    <!-- Adicion de busqueda y agregado de Empresa -->
                    <!-- Crear un dropdown con las opciones de las empresas -->
                    <div class="input-box">
                    <select name="empresa_seleccionada">
                    <!-- Obtener todas las empresas -->
                    <?php
                        // Recorrer cada empresa
                        foreach ($empresas as $empresa) {
                        // Agregar una opción al dropdown con el id_empresa como value y el nombre_empresa como texto
                        echo "<option value='" . $empresa['id_empresa'] . "'>" . $empresa['nombre_empresa'] . "</option>";
                        }
                    ?>
                    </select>
                     </div>

                        <!-- Este es un botón con una función javascript asociada que se activa al hacer clic en él -->
                        <div class="button-agregar">
                            <button type="button" onclick="redireccionEmpresa()">Agregar Empresa</button>
                        </div>
                        <!-- Aquí está la función JavaScript que se ejecuta al hacer clic en el botón -->
                        <script>
                        function redireccionEmpresa() {
                            // Esta línea redirige a otra página en su sitio
                            window.location.href = 'form_empresa.html';
                        }
                        </script>

                        <!-- Agregar un campo hidden para la cookie del nombre del profesor -->


                        <div class="button-agregar">
                            <button type="submit">Guardar</button>
                        </div>
                    </div>


                </div>
                <div class="button-container">

                </div>

        </form>


    </div>
</body>

</html>
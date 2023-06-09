<!--Incluir conexion a la Base de Datos y Query para mostrar los datos de la tabla-->

<?php include("../view/header.php"); ?>
    <!--Apertura de Clase - Formulario de Empresa-->
    <div class="containerForm">
        <form action="resources/insertar_empresa.php" method="post">
            <h2>Empresa</h2>

            <div class="content">
                
                <div class="input-box">
                    <label for="Nombre Empresa">Nombre del la Empresa:</label>
                    <input type="text" maxlength="75" placeholder="¿Cómo se llama la empresa?" name="NombreEmpresa" required>
                </div>

                <div class="input-box">
                    <label for="Ramo">Ramo:</label>
                    <select name="Ramo">
                        <option value="" selected hidden>Elegir</option>
                        <option>Industrial</option>
                        <option>Servicios</option>
                        <option>Otro</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="Sector">Sector:</label>
                    <select name="Sector">
                        <option value="" selected hidden>Elegir</option>
                        <option>Publico</option>
                        <option>Privado</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="Actividad Principal">Actividad Principal:</label>
                    <input type="text"  maxlength="75" placeholder="¿Cuál es la actividad de la empresa?" name="ActividadPrincipal" required>
                </div>

                <div class="input-box">
                    <label for="Calle">Calle Principal:</label>
                    <input type="text"  maxlength="30" placeholder="¿En dónde se encuentra?" name="Calle" required>
                </div>

                <div class="input-box">
                    <label for="Numero">Numero:</label>
                    <input type="text"  maxlength="4" placeholder="¿En qué edificio?" name="Numero" required>
                </div>

                <div class="input-box">
                    <label for="colonia">Colonia:</label>
                    <input type="text"  maxlength="30" placeholder="¿Cómo se llama la Colonia?" name="Colonia" required>
                </div>

                <div class="input-box">
                    <label for="cp">CP:</label>
                    <input type="text"  maxlength="5" placeholder="¿Codigo Postal?" name="cp" required>
                </div>

                <div class="input-box">
                    <label for="ciudad">Ciudad:</label>
                    <input type="text"  maxlength="30" placeholder="¿Cuál es la ciudad?" name="Ciudad" required>
                </div>

                <div class="input-box">
                    <label for="tel">Teléfono:</label>
                    <input type="text"  maxlength="10" placeholder="Teléfono para contactar con la organización" name="tel" required>
                </div>

                <div class="input-box">
                    <label for="fax">FAX:</label>
                    <input type="text"  maxlength="10" placeholder="Linea Telefónica para fax" name="fax" required>
                </div>

                <div class="input-box">
                    <label for="rfc">RFC:</label>
                    <input type="text"  maxlength="12" placeholder="RFC de la empresa (moral/fisica) " name="RFC" required>
                </div>

                <div class="input-box">
                    <label for="nombre del representante">Nombre(s) del Representante:</label>
                    <input type="text"  maxlength="20" placeholder="¿Quién es la cara de la empresa?" name="NombreRepresentante"
                        required>
                </div>

                <div class="input-box">
                    <label for="">Apellido Paterno: </label>
                    <input type="text"  maxlength="20" placeholder="Ingrese el apellido Paterno" name="Ape1Representante"
                        required>
                </div>

                <div class="input-box">
                    <label for="">Apellido Materno: </label>
                    <input type="text"  maxlength="20" placeholder="Ingrese el apellido Materno" name="Ape2Representante"
                        required>
                </div>
            
                <div class="input-box">
                    <label for="Puesto">Puesto:</label>
                    <input type="text"  maxlength="30" placeholder="¿Qué puesto ocupa en la organización?" name="Puesto"
                        required>
                </div>

                <div class="button-container">
                    <button type="submit">Agregar</button>


                </div>

        </form>


    </div>

<?php include("../view/footer.php"); ?>
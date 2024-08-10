<?php
$nombre = $apellido = $email = $telefono = $pais = "";
$nombreErr = $apellidoErr = $emailErr = $telefonoErr = $paisErr = "";
$datosGuardados = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $esValido = true;

    // Validar Nombre
    if (empty($_POST["nombre"])) {
        $nombreErr = "El nombre es requerido.";
        $esValido = false;
    } else {
        $nombre = limpiarDato($_POST["nombre"]);
        if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            $nombreErr = "El nombre no debe contener números ni caracteres especiales.";
            $esValido = false;
        }
    }

    // Validar Apellido
    if (empty($_POST["apellido"])) {
        $apellidoErr = "El apellido es requerido.";
        $esValido = false;
    } else {
        $apellido = limpiarDato($_POST["apellido"]);
        if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
            $apellidoErr = "El apellido no debe contener números ni caracteres especiales.";
            $esValido = false;
        }
    }

    // Validar Email
    if (empty($_POST["email"])) {
        $emailErr = "El correo electrónico es requerido.";
        $esValido = false;
    } else {
        $email = limpiarDato($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Por favor, ingrese un correo electrónico válido.";
            $esValido = false;
        }
    }

    // Validar Teléfono
    if (empty($_POST["telefono"])) {
        $telefonoErr = "El teléfono es requerido.";
        $esValido = false;
    } else {
        $telefono = limpiarDato($_POST["telefono"]);
        if (!preg_match("/^[0-9]{10}$/", $telefono)) {
            $telefonoErr = "El teléfono debe contener exactamente 10 dígitos y solo números.";
            $esValido = false;
        }
    }

    // Validar País
    if (empty($_POST["pais"])) {
        $paisErr = "Por favor, seleccione su país.";
        $esValido = false;
    } else {
        $pais = limpiarDato($_POST["pais"]);
    }

    // Si todos los datos son válidos, se considera que los datos se guardaron
    if ($esValido) {
        $datosGuardados = true;
    }
}

function limpiarDato($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <style>
        * {
            color: #74125b;
            font-style: italic;
        }
        body {
            background-color: #f396aa5b;
        }
        .form-container {
            background-color: #f396aab0;
            border-radius: 20px;
            padding: 20px;
            margin: 0 auto;
            width: 50%;
            border: 1px solid #74125b;
            text-align: center;
        }
        .form-container h2 {
            color: #74125b;
            font-style: italic;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #74125b;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #a14189;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #74125b;
        }

        .modal {
            display: none; 
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #74125b;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 10px;
        }
        .modal-content h3 {
            margin-bottom: 20px;
        }
        .modal-content button {
            background-color: #74125b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .home {
           color: #74125b;
           font-style: italic;
           font-weight: bold;
           background-color: #f396aab0;
           border-radius: 20px;
           text-align: center;
           border: 1px solid #74125b;
           text-decoration: none; 
        }
        .home-links {
          display: flex;
          gap: 10px;
        }
        .home-links a {
           padding: 10px 15px;
           background-color: #f396aab0;
           border: 1px solid #74125b;
           border-radius: 10px;
           transition: background-color 0.3s, color 0.3s;
           text-decoration: none; 
        }

        header .home-links a:hover {
          background-color: #74125b;
          color: #f396aa;
        }   
    </style>
</head>
<body>
    

<div class="form-container">
        <div class="main-nav secondary-nav">
            <div class="home-links">
                 <a class="home" href="index.html">Inicio<br></a>
            </div>
        </div>
    <h2>Registro de Usuario</h2>
    <form id="registro-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            <span id="error-nombre" class="error"><?php echo $nombreErr; ?></span>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
            <span id="error-apellido" class="error"><?php echo $apellidoErr; ?></span>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <span id="error-email" class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required pattern="[0-9]{10}">
            <span id="error-telefono" class="error"><?php echo $telefonoErr; ?></span>
        </div>
        <div class="form-group">
            <label for="pais">País:</label>
            <select id="pais" name="pais" required>
                <option value="">Seleccione su país</option>
                <option value="mexico" <?php echo $pais == "mexico" ? "selected" : ""; ?>>México</option>
                <option value="espana" <?php echo $pais == "espana" ? "selected" : ""; ?>>España</option>
                <option value="argentina" <?php echo $pais == "argentina" ? "selected" : ""; ?>>Argentina</option>
                <option value="argentina" <?php echo $pais == "ecuador" ? "selected" : ""; ?>>Ecuador</option>
                <option value="argentina" <?php echo $pais == "peru" ? "selected" : ""; ?>>Peru</option>
            </select>
            <span id="error-pais" class="error"><?php echo $paisErr; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" value="Registrarse">
        </div>
    </form>
</div>

<?php if ($datosGuardados): ?>
<!-- Modal de confirmación -->
<div id="modal-confirmacion" class="modal" style="display:block;">
    <div class="modal-content">
        <h3>Datos guardados con éxito</h3>
        <button onclick="volverInicio()">Aceptar</button>
    </div>
</div>
<?php endif; ?>

<script>
    function volverInicio() {
        window.location.href = 'index.html';
    }
</script>
</body>
</html>

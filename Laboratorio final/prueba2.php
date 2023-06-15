<!DOCTYPE html>
<html lang="ES-es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="titulo">Formulario de registro</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
</head>

<body class="body">
    <form class="form" method="post" action="">

     <h2>Formulario de registro</h2> 
        
     <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" name="nombre" placeholder="Nombre" required>
        <label for="floatingInput" class="Nombre-label">Nombre</label>
     </div>

     <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" name="primerApellido" placeholder="Primer apellido" required>
        <label for="floatingInput" class="Apellido1-label">Primer apellido</label>
     </div>

     <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" name="segundoApellido" placeholder="Segundo apellido">
        <label for="floatingInput" class="Apellido2-label">Segundo apellido</label>
     </div>
        
     <div class="form-floating mb-3">
        <input type="email" class="form-control form-control-lg" name="email" placeholder="Correo electrónico" required>
        <label for="floatingInput" class="Email-label">Correo electrónico</label>
     </div>

     <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-lg" name="usuario" placeholder="Nombre de usuario" required>
        <label for="floatingInput" class="Username-label">Nombre de usuario</label>
     </div>

     <div class="form-floating mb-3">
        <input type="password" class="form-control form-control-lg" name="contraseña" placeholder="Contraseña" required>
        <label for="floatingInput" class="Password-label">Contraseña</label>
        <span id="passwordHelpInline" class="span-contraseña">Entre 4 y 8 caracteres</span>
    
    
    <div class="form-floating mb-3">
        <input type="password" class="form-control form-control-lg" name="confirmPassword" placeholder="Confirma la contraseña" required>
        <label for="floatingInput" class="ConfirmPassword-label">Confirma la contraseña</label>

        <div class="control-group">
         <div class="Recuerdame">
           <label class="checkbox">
             <input type="checkbox"> Recuérdame
           </label>
         </div>
     </div>

     </div>         
     
     <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Acepto los términos y condiciones</label>
     </div>
     
     <div>
        <button type="submit" name="btn-submit" class="btn-crearUsuario" required>Crear usuario</button>
        <button type="button" class="btn-cancelar">Cancelar</button>
     </div>
     
        <?php
            if(isset($_POST["submit"])) {
                $nombre = $_POST["nombre"];
                $primerApellido = $_POST["primerApellido"];
                $segundoApellido = $_POST["segundoApellido"];
                $email = $_POST["email"];
                $usuario = $_POST["usuario"];
                $contraseña = $_POST["contraseña"];
                $confirmPassword = $_POST["confirmPassword"];

                if(empty($nombre) || empty($primerApellido) || empty($email) || empty($usuario) || empty($contraseña) || empty($confirmPassword)) {
                    die("Por favor, rellene los datos requeridos");
                } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    die("El correo electrónico no es válido");
                } elseif(strlen($contraseña) < 4 || strlen($contraseña) > 8) {
                    die("La contraseña debe tener entre 4 y 8 caracteres");
                }

                // Verificar correo y usuario en la base de datos (consulta a la base de datos)

                // Realizar la conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "LaboratorioFinal";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consultar si el correo ya está registrado
                $query = "SELECT * FROM `REGISTRO_USUARIOS` WHERE `EMAIL` = '$email'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    die("El correo electrónico ya está registrado, pruebe con otro");
                }

                // Consultar si el usuario ya existe
                $query = "SELECT * FROM `REGISTRO_USUARIOS` WHERE `USUARIO` = '$usuario'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    die("Este nombre de usuario ya existe, pruebe con otro");
                }

                // Insertar el registro en la base de datos
                $sql = "INSERT INTO `REGISTRO_USUARIOS` (`NOMBRE`, `PRIMER_APELLIDO`, `SEGUNDO_APELLIDO`, `EMAIL`, `USERNAME`, `CONTRASEÑA`) VALUES ('$nombre', '$primerApellido', '$segundoApellido', '$email', '$usuario', '$contraseña')";

                if ($conn->query($sql) === TRUE) {
                    echo "<h1>Registro completado con éxito</h1>";
                    echo "<p>Nombre: $nombre</p>";
                    echo "<p>Primer apellido: $primerApellido</p>";
                    echo "<p>Segundo apellido: $segundoApellido</p>";
                    echo "<p>Correo electrónico: $email</p>";
                    echo "<p>Nombre de usuario: $usuario</p>";
                } else {
                    echo "Error al registrar los datos: " . $conn->error;
                }

                $conn->close();
            }
        ?>
     
     </div>

    </form>
    
</body>
</html>

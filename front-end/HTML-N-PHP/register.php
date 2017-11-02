<!DOCTYPE html>
<?php

if(isset($_POST['submiter']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
$email = trim($_POST['email']);
$nombre = trim($_POST['nombre']);
$username = trim($_POST['username']);
$contrasenha = trim($_POST['contrasenha']);
$rep_contrasenha = trim($_POST['rep_contrasenha']);

if(empty($email))
{
    echo "<script type='text/javascript'>alert('Email vacio');</script>";
}
else if(!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email))
{
    echo "<script type='text/javascript'>alert('El email no cumple con lo establecido');</script>";
}
else if(!preg_match("/^(([a-zA-Z]{1,}\ ){1,10})([a-zA-Z]{1,})$/", $nombre))
{
    echo "<script type='text/javascript'>alert('El nombre no cumple con lo establecido');</script>";
}
else if(!preg_match("/^(([a-zA-Z0-9\_\-]{1,}))$/", $username))
{
    echo "<script type='text/javascript'>alert('El username no cumple con lo establecido');</script>";
}
else if(!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\-\\\_]{6,20}$/", $contrasenha))
{
    echo "<script type='text/javascript'>alert('La contraseña no cumple con lo establecido');</script>";
}
else if(!preg_match("/^[a-zA-Z0-9!@#\$%\^&\*\?_~\/\\\-\_]{6,20}$/", $rep_contrasenha))
{
    echo "<script type='text/javascript'>alert('La contraseña no concuerda con su predecesora');</script>";
}
else if($rep_contrasenha !== $contrasenha)
{
    echo "<script type='text/javascript'>alert('Las contraseña no concuerdan entre si');</script>";
}
else
{
     //ob_start();
       // session_start();

        include_once '../../.back-end/.others/.Dbconnect.php';

        $error = false;

        if(!isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
            $sql="INSERT INTO users(email, nombre_apellidos, username, password)
          VALUES ('$email', '$nombre', '$username', '$contrasenha')";
        }
        else {
            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
            $limite_kb = 16384;

            if (in_array($_FILES['image']['type'], $permitidos) && $_FILES['image']['128'] <= $limite_kb * 1024) {

                // Archivo temporal
                $imagen_temporal = $_FILES['image']['tmp_name'];

                // Tipo de archivo
                $tipo = $_FILES['image']['type'];

                $data = file_get_contents($imagen_temporal);

                $data=$conn->real_escape_string($data);

                $sql="INSERT INTO users(email, nombre_apellidos, username, password, tipo_imagen, imagen)
          VALUES ('$email', '$nombre', '$username', '$contrasenha', '$tipo', '$data')";} else {
                echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
            }
        }
        if(!mysqli_query($conn, $sql)){
            echo "<p> <button onclick='window.history.back()'>Volver atras</button></p>";
            die('Error: ' . mysqli_error($conn));
        }

        echo "one record added";

        mysqli_close($conn);
        clearstatcache();?>
<script>
    alert('El regitro se ha realizado correctamente.');
    document.location.href = 'login.php';
</script>
<?php
}
}
?>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Registro</title>
    <link rel='stylesheet' type='text/css' href='../estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='../estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='../estilos/smartphone.css' />

    <style>
        div #blk{
            background-color: rgba(195, 195, 195, 0.62);
            width:735px;
            height:485px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        table {
         margin: auto;
        border:0.25px solid rgba(10, 131, 169, 0.93);
        }

        form   {
            background-color: #d2d2d2;
            width:435px;
            height:545px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }
    </style>

</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <span class="right"><a href="login.php">Login</a></span>
        <span class="right" style="display:none;"><a href="/logout">Logout</a></span>
        <h2>Quiz: el juego de las preguntas</h2></br>
        <h3>Registro</h3>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <span><a href='../html/layout.html'>Inicio</a></span>
        <span><a href='../html/creditos.html'>Creditos</a></span>
    </nav>
    <section class="main" id="s1">
        <div align="left"><div id="blk" align="left">
                </br>
                <table border="1">
                    <tr>

                        <form id='freg' name='fregister' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="Post" enctype="multipart/form-data">
                            <td>
                                <?php
                                if(isset($error))
                                {
                                ?>
                    <tr>
                        <td id="error"><?php echo $error; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    Email*: &nbsp;</br><input type="text" size="50" id="e-mail" name="email" placeholder="p.e. alumnoxyz@ikasle.ehu.eus" value="<?php if(isset($email)){echo $email;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></br>
                    Nombre, Apellidos*: &nbsp;</br><input type="text" size="50" id="name" name="nombre" placeholder="p.e. Nombre, Apellido1 Apellido2 :" value ="<?php if(isset($nombre)){echo $nombre;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?>></br>
                    Username*: &nbsp;</br><input type="text" size="50" id="nick" name="username" placeholder="p.e. pepitoXY" value="<?php if(isset($username)){echo $username;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?>></br>
                    Password*: &nbsp;</br><input type="password" size="50" id="pass" name="contrasenha" placeholder="p.e. ~!dsd%?@#$^*-_/\101-  o password seguro?" value="<?php if(isset($contrasenha)){echo $contrasenha;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?>></br>
                    Repetir password*: &nbsp;</br><input type="password" size="50" id="rep_pass" name="rep_contrasenha" placeholder="p.e. Abcd1234 o password seguro?" value="<?php if(isset($rep_contrasenha)){echo $rep_contrasenha;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?>></br>
                    <input type="submit" id="submiter" name="submiter" value="Enviar" align="center">&nbsp;
                    <input type=reset value="Clear Form"></br></br>
                    </td>
                    <td>
                        <div align="center">
                            <input id="file_url" type="file" id="img" name="image" align="center"></br>
                            <div align="left">
                                <img id="img_destino" src="../resources/img/default.jpg" alt="Tu imagen" align="center" width="256px">
                            </div>
                        </div>
                    </td>
                    </form>
                    </tr>
                </table>
            </div></div>
    </section>
    <footer class='main' id='f1'>
        <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
        <a href='https://github.com/swg27/'>Link GITHUB</a>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file_url").change(function(){
        mostrarImagen(this);
    });
</script>
</body>
</html>
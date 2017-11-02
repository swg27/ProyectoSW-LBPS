<!DOCTYPE html>

<?php

if(isset($_GET['user']))
{
$email = $_GET['user'];
if (empty($email)) {
echo 'error 1';
} else if (!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email)) {
echo 'error 2';
}else {
//ob_start();
//session_start();

include_once '../../../.back-end/.others/.Dbconnect.php';

$error = false;

$sql = "SELECT email, imagen FROM users WHERE email='$email' ";

if (!mysqli_query($conn, $sql)) {
echo "<script type='text/javascript'>alert('Credenciales incorrectas!');</script>";
die('Error: ' . mysqli_error($conn));
}else{

$user = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($user);
//mysqli_close($conn);
//clearstatcache();

if($email == $row['email']) {

$user_img = $row['imagen'];

?>


<?php



if(isset($_POST['submiter']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
$email = $_GET['user'];
$level = trim($_POST['level']);
$tema = trim($_POST['tema']);
$question = trim($_POST['question']);
$correctAns = trim($_POST['correctAns']);
$incorrectAns1 = trim($_POST['incorrectAns1']);
$incorrectAns2 = trim($_POST['incorrectAns2']);
$incorrectAns3 = trim($_POST['incorrectAns3']);

if(empty($email))
{
    echo "<script type='text/javascript'>alert('El email se encuentra vacio');</script>";
}
else if(!preg_match("/^(([a-zA-Z]{1,})+[0-9]{3})+@ikasle\.ehu\.+(eus|es)$/", $email))
{
    echo "<script type='text/javascript'>alert('El email no cumple con lo establecido');</script>";
}
else if(empty($level))
{
    echo "<script type='text/javascript'>alert('Introcduce un nivel');</script>";
}
else if(!preg_match("/^[1-5]{1}$/", $level))
{
    echo "<script type='text/javascript'>alert('Introduce un nivel valido');</script>";
}
else if(empty($tema))
{
    echo "<script type='text/javascript'>alert('Introduce un tema');</script>";
}
else if(empty ($question))
{
    echo "<script type='text/javascript'>alert('Introduce una pregunta');</script>";
}
else if(strlen($question)<10)
{
    echo "<script type='text/javascript'>alert('La pregunta debe contener al menos 10 caracteres');</script>";
}
else if(empty($correctAns))
{
    echo "<script type='text/javascript'>alert('Introduce una respuesta');</script>";
}
else if(empty($incorrectAns1))
{
    echo "<script type='text/javascript'>alert('Introduce una respuesta');</script>";
}
else if(empty($incorrectAns2))
{
    echo "<script type='text/javascript'>alert('Introduce una respuesta');</script>";
}
else if(empty($incorrectAns3))
{
    echo "<script type='text/javascript'>alert('Introduce una respuesta');</script>";
}

else
{

//ob_start();
//session_start();

//include_once '../../.back-end/.others/.Dbconnect.php';

$error = false;

if(!isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
    $sql="INSERT INTO Quiz(dificultad, tema, pregunta, respuesta, no_respuesta_1, no_respuesta_2, no_respuesta_3, email)
          VALUES ($level,'$tema','$question','$correctAns','$incorrectAns1','$incorrectAns2','$incorrectAns3','$email')";
}
else {
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;

    if (in_array($_FILES['image']['type'], $permitidos) && $_FILES['image']['size'] <= $limite_kb * 1024) {

        // Archivo temporal
        $imagen_temporal = $_FILES['image']['tmp_name'];

        // Tipo de archivo
        $tipo = $_FILES['image']['type'];

        $data = file_get_contents($imagen_temporal);

        $data=$conn->real_escape_string($data);

        $sql = "INSERT INTO Quiz(dificultad, tema, pregunta, respuesta, no_respuesta_1, no_respuesta_2, no_respuesta_3, email, image, tipo_imagen)
          VALUES ($level,'$tema','$question','$correctAns','$incorrectAns1','$incorrectAns2','$incorrectAns3','$email', '$data', '$tipo')";
    } else {
        echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
    }
}
if(!mysqli_query($conn, $sql)){
    echo "<p> <button onclick='window.history.back()'>Volver atras</button></p>";
    die('Error: ' . mysqli_error($conn));
}

echo "one record added";

mysqli_close($conn);
clearstatcache();

//$email = trim($_POST['email']);
if(true){
echo "<script type='text/javascript'> alert('insercion realizada correctamente'); </script>";
}
?>
<script>
    alert('podrias ver las preguntas si le parece.');
    window.location.assign('../html/layout.php?user=<?php echo $_GET['user'];?>');
</script>
<?php
}
}
?>

<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='../../estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='../../estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='../../estilos/smartphone.css' />

    <style>

        #ident{
            margin: auto;
            background-color: rgba(10, 56, 75, 0.62);
            width:750px;
            height:156px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        #t_iden{
            background-color: rgba(255, 255, 255, 0.79);
            width:750px;
            height:156px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        .user {
            margin: auto;
            color: dodgerblue;
        }

        div #blk{
            background-color: rgba(195, 195, 195, 0.62);
            width:750px;
            height:485px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }

        table {
            margin: auto;
            /*border:0.25px solid rgba(10, 131, 169, 0.93);*/
        }

        form   {
            margin: auto;
            background-color: #d2d2d2;
            width:720px;
            height:545px;
            border:1px solid rgba(10, 131, 169, 0.93);
            padding:10px;
        }
        
        #img_zone {
            margin-top: 0%;
            padding-top: 0%;
            vertical-align: top;
        }
        
        div #img_cont{
            margin-top: 0%%;
            padding-top: 0%;
            vertical-align: top;
        }

        .err {
            margin: auto;
            color: red;
            width: 256px;
            padding: 10px;
            font-size: larger;
            font-family: monospace;
        }

        <?php
        if(isset($error))
        {
            ?>
        input:focus
        {
            border: red 2px;
        }
        <?php
    }
    ?>


    </style>

</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <div id='ident' align="center">
        <table id="t_iden" width="64px">
            <tr>
                <td>
        <p align='center' class='user'><?php echo $email?></p>
                </td>
          <td id='td_img' height="64px">
             <?php echo '<img id="u_img" height="128px" src="data:image/type;base64,'.base64_encode( $row['imagen']).' "/>'?>
          </td>
               </tr>
           </table>
        </div>
        <span class="right"><a onclick="alert('Cierre de sesion')" href="../../html/layout.html">Logout</a></span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
   <span><a href='../html/layout.php?user=<?php echo $email;?>'>Inicio</a></span>
           <span><a href='../html/creditos.php?user=<?php echo $email;?>'>Creditos</a></span>
        <span><a href='../../../.back-end/php/.ver-preguntas.php?user=<?php echo $email;?>'>ver preguntas</a></span>
    </nav>
    <section class="main" id="s1">
        <div align="left"><div id="blk" align="left">
                </br>
                <table >
                    <form id='fpreguntas' name='fpreguntas' action='insertar-pregunta.php?user=<?php echo $email;?>' method="Post" enctype="multipart/form-data">
                    <tr>

                            <td>

                    Email*: &nbsp;</br><input type="text" disabled size="50"  id="e-mail" name="email" placeholder="p.e. alumno@ikasle.ehu.eus" value="<?php if(isset($email)){echo $email;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></br>
                    Dificultad de la pregunta*: &nbsp;</br><input type="text" size="50" id="lvl" name="level" placeholder="p.e. 4:" value ="<?php if(isset($level)){echo $level;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?>/></br>
                    Tema*: &nbsp;</br><input type="text" size="50" id="tm" name="tema" placeholder="p.e. Matematicas" value="<?php if(isset($tema)){echo $tema;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?>/></br>
                    Enunciado de la pregunta*: &nbsp;</br><input type="text" size="50" id="Qst" name="question" placeholder="p.e. Descubrio las propiedades de los fractales:" value="<?php if(isset($question)){echo $question;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?>/></br>
                    Repuesta correcta*: &nbsp;</br><input type="text" size="50" id="ans" name="correctAns" placeholder="p.e. Nikola Tesla" value="<?php if(isset($correctAns)){echo $correctAns;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?>/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns1" name="incorrectAns1" placeholder="p.e. Benoît Mandelbrot" value="<?php if(isset($incorrectAns1)){echo $incorrectAns1;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?>/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns2" name="incorrectAns2" placeholder="p.e. Homer Simpson" value="<?php if(isset($incorrectAns2)){echo $incorrectAns2;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?>/></br>
                    Respuesta incorrecta*: &nbsp;</br><input type="text" size="50" id="noAns3" name="incorrectAns3" placeholder="p.e. Thomas Edison" value="<?php if(isset($incorrectAns3)){echo $incorrectAns3;} ?>"  <?php if(isset($code) && $code == 8){ echo "autofocus"; }  ?>/></br></br>
                    <input type="submit" id="submiter" name="submiter" value="Enviar" align="center">&nbsp;
                    <input type=reset value="Clear Form"></br></br>
                    </td>
                    <td id="img_zone" align="top">
                        <div id="img_cont" align="center">
                            <input id="file_url" type="file" id="img" name="image" align="right"></br>
                            <div align="center">
                                <img id="img_destino" src="../resources/img/default.jpg" alt="Tu imagen" align="center" width="256px">
                            </div>
                        </div>
                    </td>
                    </form>
                    </tr>
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
                </table>
            </div>


        </div>
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

<?php
}else
{
    echo "\n Solo pueden acceder usuarios registrados. \n";
    echo "<a href='../../HTML-N-PHP/register.php'>Registrarse</a>";
}
}
}
}
else
{
    echo "\n Error";
}
?>
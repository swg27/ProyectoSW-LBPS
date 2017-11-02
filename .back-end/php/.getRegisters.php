<?php

//ob_start();
//session_start();

//if(isset($_SESSION['user'])!=""){
    //  header("Location: index.php");
//}
include_once '../.others/.Dbconnect.php';
$error=false;

$preguntas=mysqli_query($conn, "SELECT * FROM users");
echo '<table border=1> 
        <tr> 
        <th>email</th>
        <th>Imagen relacionada</th>
        </tr>';

while($row = mysqli_fetch_array($preguntas)){
    echo
        '<tr>
    <td align="center">'.$row['email'].'</td>
    <td align="center">'
        .'<img src="data:image/type;base64,'.base64_encode( $row['imagen']).'"/>'.
        '</td>
    </tr>';
}
echo '</table>';
$preguntas->close();
mysqli_close($conn);

?>
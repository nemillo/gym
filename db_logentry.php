<?php
session_start();
$user = null;
// Open database connection
$hostname = "sql112.epizy.com";
$user = "epiz_28718908";
$password = "weqmXe12345";

$conn = mysqli_connect($hostname, $user, $password,"epiz_28718908_diario");
$conn -> set_charset("utf8");

if (isset($_SESSION['usuario'])) {
  $user_name = $_SESSION['usuario'];
   
} else {
  header('Location: /gym/login.php');
}

$post = isset($_POST['Submit']) ? $_POST['Submit'] : NULL;

if ($post == 'Enter') {
    // Enter new entry
    $date = $_POST['Ymd']; // Remember, date is an integer type
    $comentario = $_POST['comentario'];
    $escuchando = $_POST['escuchando'];
    $cardio = $_POST['cardio'];
    $abdominales = $_POST['abdominales'];
    $espalda = $_POST['espalda'];
    $pecho = $_POST['pecho'];
    $biceps = $_POST['biceps'];
    $triceps = $_POST['triceps'];
    $hombros = $_POST['hombros'];
    $piernas = $_POST['piernas'];
    $peso = $_POST['peso'];
    $grasa = $_POST['grasa'];

    $query = "INSERT INTO gym (fecha, comentario, escuchando, cardio, abdominales, espalda, pecho, biceps, triceps, hombros, piernas, peso, grasa)
       VALUES('$date', '$comentario','$escuchando','$cardio','$abdominales','$espalda','$pecho','$biceps','$triceps','$hombros','$piernas','$peso','$grasa' )";
    
   $result = $conn->query($query);
    if (mysqli_affected_rows($conn) == 1) {
      header("Location: index.php");
    } else {
      echo "There was a problem inserting your text.";
      print_r($query);
      print_r($result);
      print_r($post);
      exit;
    }
  }

else {?>  
<HTML>
<HEAD>
<TITLE>Weblog data entry screen</TITLE>
</HEAD>
<BODY>
<FORM ACTION="db_logentry.php" METHOD="POST">
<P>Fecha:<BR>
<TEXTAREA NAME="Ymd" COLS=12 ROWS=1 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Comentario:<BR>
<TEXTAREA NAME="comentario" COLS=75 ROWS=20 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Escuchando:<BR>
<TEXTAREA NAME="escuchando" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Cardio:<BR>
<TEXTAREA NAME="cardio" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Abdominales:<BR>
<TEXTAREA NAME="abdominales" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Espalda:<BR>
<TEXTAREA NAME="espalda" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Pecho:<BR>
<TEXTAREA NAME="pecho" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Biceps:<BR>
<TEXTAREA NAME="biceps" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Triceps:<BR>
<TEXTAREA NAME="triceps" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Hombros:<BR>
<TEXTAREA NAME="hombros" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Piernas:<BR>
<TEXTAREA NAME="piernas" COLS=75 ROWS=5 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Peso:<BR>
<TEXTAREA NAME="peso" COLS=10 ROWS=1 WRAP="VIRTUAL"></TEXTAREA></P>
<P>Grasa:<BR>
<TEXTAREA NAME="grasa" COLS=10 ROWS=1 WRAP="VIRTUAL"></TEXTAREA></P>
<P><INPUT TYPE="SUBMIT" NAME="Submit" VALUE="Enter"></P>
</FORM>
</BODY>
</HTML>
<?php 
}

?>

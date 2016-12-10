<?php

$rezultat = $odogovor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['rezultat']) && !empty($_POST['odogovor'])){
                $rezultat = test_input($_POST['rezultat']);
                $odogovor = test_input($_POST['odogovor']);
                if ($rezultat == $odogovor){
                        notifyAnswer(True);
                        deliverCandy();
                }
                else {
                        notifyAnswer(False);
                        $rezultat = $odogovor = "";
                }
        }
        else {
                notifyAnswer(False);
                $rezultat = $odogovor = "";
        }
}

$i=rand(1,3);
$a=rand(0,10);
$b=rand(0,10);
if ($a < $b){
        $k=$a;
        $a=$b;
        $b=$k;
}

function notifyAnswer($tf){
        if ($tf) {
                echo('Тачно');
        }
        else {
                echo "Нетачно";
        }
}

function test_input($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}

function deliverCandy(){
        exec("./giveCandy");
        return True;
}

function calc_string($mathString){
        $doCalc = create_function("", "return (" . $mathString . ");" );
        return $doCalc();
}

function mat1($a, $b){
        echo( "<h2>".$a . " + " . $b ." = </h2>" );
        $izracunaj=calc_string("$a + $b");
        return $izracunaj;
}
function mat2($a, $b){
        echo( "<h2>".$a . " - " . $b ." = </h2>" );
        $izracunaj=calc_string("$a - $b");
        return $izracunaj;
}
function mat3($a, $b){
        echo( "<h2>".$a . " x " . $b ." = </h2>" );
        $izracunaj=calc_string("$a * $b");
        return $izracunaj;
}

echo('<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Тестирамо се!</title>
</head>
<body>
<div>
<div>
<h3>Израчунај:</h3>');
$rezultat=call_user_func("mat".$i, $a, $b);
echo('
<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="POST">
	<label>
                <input type="text" name="odgovor"/>
                <input type="submit" value="Реши"/>
                <input type="hidden" name="a" value="'.$a.'"/>
                <input type="hidden" name="b" value="'.$b.'"/>
                <input type="hidden" name="rezultat" value="'.$rezultat.'"/>
        </label>
	</form>
        </div>
<h2>' . $rezultat . '</h2>
</div>
</body>
</html>
');

?>

<?php
$i=rand(1,3);
$a=rand(0,10);
$b=rand(0,10);
if ($a < $b){
        $k=$a;
        $a=$b;
        $b=$k;
}

function deliverCandy(){
        system("python candyGo.py");
        return True;
}

function calc_string( $mathString ){
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

deliverCandy();
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
<form action="index.php" method="POST">
	<label>
                <input class="numeric" type="tel" min="0" step="1"/>
                <input type="submit" value="Реши"/>
        </label>
	</form>
        </div>
<h2>' . $rezultat . '</h2>
</div>
</body>
</html>
');

?>
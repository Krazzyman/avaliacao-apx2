<?php
echo "<pre>";
include('functions.php');

$tabelaGrupos = divideGrupos('equipes.csv', 1);

print_r($tabelaGrupos);

echo "<br>";

print_r(verificaTimes($tabelaGrupos, 0, 2));

print_r(computaMelhoresColocados($tabelaGrupos, 0, 2));


for ($i = 1; $i <= 4; $i++) {
    $tabelaGrupos = divideGrupos('equipes.csv', $i);

    print_r(computaMelhoresColocados($tabelaGrupos, 0, 2));
}

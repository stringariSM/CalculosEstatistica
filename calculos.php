<?php
/**
 * Created by PhpStorm.
 * User: gabri
 * Date: 10/08/2017
 * Time: 20:27
 */
if($_POST != NULL){
    $lArrayResult = array();

    $lNumero = $_POST['numeros'];

    $lArrayNumeros = explode("-", $lNumero);

    //Quantidade de Números
    array_push($lArrayResult, array('title' => "Quantidade de Números", 'value' => count($lArrayNumeros)));

    //MODA
    $lModa = array_count_values($lArrayNumeros);

    $lCountModa = 0;
    $lNumeroModa = NULL;
    foreach ($lModa as $lKey => $lValue){
        if($lValue > $lCountModa){
            $lNumeroModa = $lKey;
            $lCountModa = $lValue;
        }
    }

    array_push($lArrayResult, array('title' => "Moda", 'value' => $lNumeroModa));

    //MEDIANA
    // Ordena os valores do array
    sort($lArrayNumeros);

    //array_push($lArrayResult, array('title' => "Ordenado", 'value' => implode($lArrayNumeros, " - ")));

    // Total de indices do array
    $lArraySize = sizeof($lArrayNumeros);
    if($lArraySize % 2 == 1){
        $lCentral = $lArraySize / 2; // como entrou aqui é porque é ímpar, divide o numero total / 2
        $lCentral = $lCentral - 0.5; // como os indices da matriz só podem ser decimais(inteiros), e o resultado nesse caso será um float, retira-se 0.5
        $lMediana = $lArrayNumeros[$lCentral]; // passa o valor da matriz contido no indice central
    }
    else {
        $lCentral = $lArraySize / 2; // nesse caso o total de indices da matriz é par
        $x1 = $lCentral--; // pega um indice abaixo do indice central
        $x2 = $lCentral++; // pega um indice acima do indice central
        $lMediana = ($lArrayNumeros[$x1] + $lArrayNumeros[$x2]) / 2; // soma o VALOR contido em cada indice e divide / 2
    }

    array_push($lArrayResult, array('title' => "Mediana", 'value' => $lMediana));

    $lSoma = 0;
    $lCont = 0;
    foreach ($lArrayNumeros as $lKey => $lValue){
        $lSoma = $lSoma + $lValue;
        $lCont++;
    }


    $lMedia = $lSoma / $lCont;

    //MÉDIA
    array_push($lArrayResult, array('title' => "Média", 'value' => round($lMedia,4)));

    $lArrayVariancia = array();
    $lSomaVariancia = 0;
    foreach ($lArrayNumeros as $lKey => $lValue){
        array_push($lArrayVariancia, ((float)$lValue -  (float)$lMedia)**2);
    }

    foreach ($lArrayVariancia as $lKey => $lValue){
        $lSomaVariancia =  (float)($lSomaVariancia + $lValue);
    }

    $lVariancia = (float)(($lSomaVariancia/($lCont-1)));

    array_push($lArrayResult, array('title' => "Variância", 'value' => round($lVariancia, 4)));

    $lDesvioPadrao = round(sqrt($lVariancia),4);

    array_push($lArrayResult, array('title' => "Desvio Padrão", 'value' => $lDesvioPadrao));

    $lCoeficienteVariacao = round($lDesvioPadrao/$lMedia,4);

    array_push($lArrayResult, array('title' => "Coeficiênte de Variação", 'value' => $lCoeficienteVariacao));
    array_push($lArrayResult, array('title' => "Coeficiênte de Variação em Porcentagem", 'value' => $lCoeficienteVariacao*100 . '%'));

    $ic = $_POST['ic'];
    $indice = array(
        '90' => '1.65',
        '95' => '1.96',
        '99' => '2.58',
        '10' => '1.65',
        '5' => '1.96',
        '1' => '2.58',
    );
    $indice = (float) $indice[$ic];
    $ltotal = count($lArrayNumeros);

    $calc = (float)($indice*($lDesvioPadrao/(sqrt($ltotal))));
    $margem = round($calc, 4);

    array_push($lArrayResult, array('title' => "Margem", 'value' => '+- '.$margem));
    array_push($lArrayResult, array('title' => "Resultado em Texto", 'value' => 'Entre '.($lMedia-$margem).' e '.($lMedia+$margem)));

    //echo '<pre>';die(var_dump($result));;

    echo html_entity_decode(json_encode($lArrayResult));
    exit;
}
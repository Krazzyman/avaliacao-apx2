<?php
function divideGrupos(string $file_name, int $index = null)
{
    /* Criando Array */
    $tabelaGrupos = [];

    /* Verificando se o arquivoexiste */
    if (file_exists($file_name)) {

        /* Verificando se o arquivo pode ser lido */
        if (($handle = fopen($file_name, "r")) !== FALSE) {

            /* While para ler a tabela e gerar as informações separando as colunas e valores com vírgula */
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $tabelaGrupos += [$data[4] => []];
                array_push($tabelaGrupos[$data[4]], [$data[0], $data[1], $data[2], $data[3]]);
            }

            /* Fechando o arquivo aberto */
            fclose($handle);
        }

        /* Verificando se foi informado o index */
        if ($index == null) {
            return $tabelaGrupos;
        } else {
            /* Verificando se existe o index */
            if (isset($tabelaGrupos['grupo ' . $index])) {
                return $tabelaGrupos['grupo ' . $index];
            } else {
                return $tabelaGrupos;
            }
        }
    } else {
        die("Arquivo não encontrado");
    }
}

/* Função para verificar se todos os valores de um array são iguais */
function array_same_value(array $array, string $value)
{
    foreach ($array as $elements) {
        if ($elements != $value) {
            return false;
        }
    }
    return true;
}

function verificaTimes(array $tabelaGrupos, int $index, $partidas)
{
    /* Cria o Array */
    $partidasJogadas = [];

    /* Insere no array o numero de repetições de cada time */
    foreach ($tabelaGrupos as $grupos) {

        /* Verifica se o já existe o indice do time 1 */
        if (isset($partidasJogadas[$grupos[0]])) {
            $partidasJogadas[$grupos[$index]] += 1;
        } else {
            $partidasJogadas[$grupos[$index]] = 1;
        }

        /* Verifica se o já existe o indice time 2 */
        if (isset($partidasJogadas[$grupos[2]])) {
            $partidasJogadas[$grupos[$index + 2]] += 1;
        } else {
            $partidasJogadas[$grupos[$index + 2]] = 1;
        }
    }

    return array_same_value($partidasJogadas, $partidas);
}

function computaMelhoresColocados(array $tabelaGrupos, int $index, int $partidas)
{

    $resultadoBooleano = verificaTimes($tabelaGrupos, $index, $partidas);
    if ($resultadoBooleano == true) {
        $tabelaGruposOrdenados = [];
        foreach ($tabelaGrupos as $grupos) {
            /* Verifica se o já existe o indice do time 1 */
            if (isset($partidasJogadas[$grupos[0]])) {
                $tabelaGruposOrdenados[$grupos[$index]] += $grupos[$index + 1];
            } else {
                $tabelaGruposOrdenados[$grupos[$index]] = $grupos[$index + 1];
            }

            /* Verifica se o já existe o indice time 2 */
            if (isset($tabelaGruposOrdenados[$grupos[2]])) {
                $tabelaGruposOrdenados[$grupos[$index + 2]] += $grupos[$index + 3];
            } else {
                $tabelaGruposOrdenados[$grupos[$index + 2]] = $grupos[$index + 3];
            }
        }
        /* ordendano o resultado de forma decrescente */
        arsort($tabelaGruposOrdenados);
        return $tabelaGruposOrdenados;
    } else {
        return [];
    }
}

<?php
function numeroParaString($numero)
{
    if ($numero >= 1000000 && $numero < 1000000000) {
        return round($numero / 1000000) . 'milhões';
    } else if ($numero >= 1000 && $numero < 1000000) {
        return round($numero / 1000) . 'mil';
    } else {
        return $numero;
    }
}

function money($value, $R = true)
{
    $value = is_numeric($value) ? $value : 0;
    if ($R) :
        return 'R$ ' . number_format($value, 2, ',', '.');
    else :
        return number_format($value, 2, ',', '.');
    endif;
}

function noMoney($value)
{
    $value = str_replace('R$', '', $value);
    $value = strpos($value, ',') ? str_replace('.', '', $value) : $value;
    $value = trim(str_replace(',', '.', $value));
    return floatval($value);
}

function formatPhoneNumber($number)
{
    // Converter o número para string
    $numberStr = strval($number);
    // Remover caracteres não numéricos e garantir o formato internacional
    return preg_replace('/\D/', '', $numberStr);
}


function mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}
function maskPhone($val, $whatsapp = false)
{
    $val = formatPhoneNumber($val);
    if (strlen($val) == 13) :
        $val = substr($val, 2);
        $return = mask($val, '(##) #####-####');
    elseif (strlen($val) == 12) :
        $val = substr($val, 2);
        $return = mask($val, '(##) ####-####');
    elseif (strlen($val) == 11) :
        $return = mask($val, '(##) #####-####');
    elseif (strlen($val) == 10) :
        $return = mask($val, '(##) ####-####');
    else :
        return false;
    endif;
    if ($whatsapp) :
        return 'https://wa.me/55' . $val;
    else :
        return $return;
    endif;
}

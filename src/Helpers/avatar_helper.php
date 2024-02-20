<?php
function avatar($nome, $size = 70, $background = 'random', $bold = true)
{
    $nome = str_replace(' ', '+', $nome);
    return 'https://eu.ui-avatars.com/api/?name=' . $nome . '&size=' . $size . '&background=' . $background . '&bold=' . ($bold ? 'true' : 'false');
}

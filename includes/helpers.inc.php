<?php
function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
    echo html($text);
}

function markdown2html($text)
{
    $text = html($text);

    // Полужирное начертание
    $text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<em>$1</em>', $text);

    // Курсивное начертание
    $text = preg_replace('/_([^_]+)_/', '<em>$1</em>', $text);
    $text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);

    // Абзацы
    $text = '<p>' . preg_replace("/\n\n", '</p><p>', $text) . '</p>';
    // Разрывы строк
    $text = str_replace("\n", '<br>', $text);


    // Преобразуем стиль Windows (\r\n) в Unix (\n)
    $text = preg_replace('/\r\n/', "\n", $text);
    // Преобразуем стиль Macintosh (\r) в Unix (\n)
    $text = preg_replace('/\r/', "\n", $text);

    // [Текст ссылки](Адрес URL)
    $text = preg_replace(
        '/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i',
        '<a href="$2">$1</a>',
        $text
    );
    return $text;
}

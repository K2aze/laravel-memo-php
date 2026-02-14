<?php
/**
 * タイトルを指定してヘッダーを作成
 *
 * @param string $title
 * @return string
 */
function getHeader($title)
{
    return <<<EOF
    <head>
        <meta charset="utf-8" />
        <title>SimpleMemo | {$title}</title>
        <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../public/css/main.css" />
        <script defer src="../public/js/all.js"></script>
    </head>
EOF;
}
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
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
          <script src="../public/js/main.js" defer></script>
          <link rel="stylesheet" type="text/css" href="../public/css/main.css" />
      </head>
  EOF;
}

<?php

function markdownToHtml($text)
{
    /*
    * CONDIZIONAMENTO TABELLE
    */
    //apre <TABLE>
    $pattern = "/([^\|]\n)\|/i";
    $text = preg_replace($pattern, "$1<table class=\"table table-success table-striped\">\n<thead>\n<tr>\n<th>", $text);
    //chiude </THEAD>
    $pattern = "/\|\n\|--[-|\|]+/i";
    $text = preg_replace($pattern, "</th>\n</tr>\n</thead>\n<tbody>", $text);
    //chiude </TABLE>
    $pattern = "/(\|)\n[^\|]/i";
    $text = preg_replace($pattern, "$1\n</tbody>\n</table>\n", $text);
    //chiude colonne in <THEAD>
    while (preg_match_all("/(<th>).+\|(.+<)/i", $text)) {
        $pattern = "/(<th>.+)\|(.+<)/i";
        $text = preg_replace($pattern, "$1</th><th>$2", $text);
    }
    //aggiunge <TR> alle altre righe
    $pattern = "/\n\|/i";
    $text = preg_replace($pattern, "\n<tr><td>", $text);
    //aggiunge </TR> alle altre righe
    $pattern = "/\|\n/i";
    $text = preg_replace($pattern, "</td></tr>\n", $text);
    //chiude colonne in <TBODY>
    while (preg_match_all("/(<tr>.+)\|(.+<)/i", $text)) {
        $pattern = "/(<tr>.+)\|(.+<)/i";
        $text = preg_replace($pattern, "$1</td><td>$2", $text);
    }

    /*
    * CONDIZIONAMENTO ALTRI MARKER
    */
    //mette <B>---</b> al posto di **---***
    $pattern = "/\*\*([^\*]+)\*\*/i";
    $text = preg_replace($pattern, "<b>$1</b>", $text);

    //mette <i>---</i> al posto di *---*
    $pattern = "/\*([^\*]+)\*/i";
    $text = preg_replace($pattern, "<i>$1</i>", $text);

    //mette <pre>---</pre> al posto di `---`
    $pattern = "/`(.+)`/i";
    $text = preg_replace($pattern, "<pre>$1</pre>", $text);

    //~~Barrato~~
    //mette <del>---</del> al posto di `~~---~~`
    $pattern = "/~~([^~]+)~~/i";
    $text = preg_replace($pattern, "<del>$1</del>", $text);

    //mette <h3>---</h3> al posto di ### ---
    $pattern = "/### (.+)/i";
    $text = preg_replace($pattern, "<h3>$1</h3>", $text);

    //mette <h2>---</h2> al posto di ## ---
    $pattern = "/## (.+)/i";
    $text = preg_replace($pattern, "<h2>$1</h2>", $text);

    //mette <h1>---</h1> al posto di ## ---
    $pattern = "/# (.+)/i";
    $text = preg_replace($pattern, "<h1>$1</h1>", $text);

    //sostituisce \n con </br> ma solo se lontano da <TAG>
    $pattern = "/([^>])\n/i";
    $text = preg_replace($pattern, "$1</br>", $text);

    return ($text);
}

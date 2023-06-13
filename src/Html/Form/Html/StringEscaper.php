<?php
declare(strict_types=1);

namespace Html\Form\Html;

trait StringEscaper
{
    public static function escapeString(?string $string): string
    {
        if($string !== null) {
            return htmlspecialchars($string, flags: ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, encoding: 'UTF-8');
        } else {
            return '' ;
        }
    }

}
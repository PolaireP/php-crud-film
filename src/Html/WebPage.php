<?php

declare(strict_types=1);

namespace Html;

use Html\Form\Html\StringEscaper;

class WebPage
{
    use StringEscaper;
    private string $head;
    private string $title;
    private string $body;

    /**
     * @param string $title
     */
    public function __construct(string $title = '')
    {
        $this->title = $title;
        $this->head = '';
        $this->body = '';

    }

    /** Accesseur de head.
     *
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /** Accesseur de body
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /** Accesseur du titre.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** Setter du titre de page
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** Ajout de contenu au corps de page
     *
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= "        ". $content;
    }

    /** Ajout de contenu à l'entête de page.
     *
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;

    }

    /** Ajout de contenu CSS
     *
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>\n" . $css . "\n</style>");
    }

    /** Ajout d'un lien vers une feuille CSS
     *
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead(
            '<link type="text/css" rel="stylesheet" href="' . $url . '">'
        );
    }

    /** Ajout de contenu JavaScript dans la page
     *
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead('<script>' . $js . '</script>');
    }

    /** Ajout d'un script JavaScript via une URL
     *
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead('<script src="' . $url . '"></script>');
    }

    /** Protège les caractères spéciaux pouvant dégrader la page Web
     *
     * @param string $string
     * @return string
     */
    public static function escapeString(string $string): string
    {
        return htmlspecialchars($string, flags: ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, encoding: 'UTF-8');
    }

    /** Date de la dernière modification du script principal
     *
     * @return string
     */
    public function getLastModification(): string
    {
        date_default_timezone_set('Europe/Paris');
        return "Dernière modification : " . date("F d Y H:i:s.", getlastmod());
    }

    /** Mise en forme de la page web sous format HTML
     *
     * @return string
     */
    public function toHTML(): string
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                     <meta http-equiv="X-UA-Compatible" content="ie=edge">
                     {$this->getHead()}
                     <title>{$this->getTitle()}</title>
            </head>
            <body>
        {$this->getBody()}
            </body>
        </html>
        HTML;


    }

}

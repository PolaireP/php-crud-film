<?php

declare(strict_types=1);

namespace Html;

class AppWebpage extends WebPage
{
    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->appendCssUrl('/css/style.css');
    }

    public function toHTML(): string
    {
        return <<<HTML
            <!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
                 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
                 {$this->getHead()}
                 <title>{$this->getTitle()}</title>
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>
                </header>
                
                <main class="content">
            {$this->getBody()}
                </main>
              
                <footer class="footer">
                    <h1>{$this->getLastModification()}</h1>
                </footer>
            </body>
            </html>
            HTML;

    }
}

<?php

namespace Views;

class LayoutView {

    private $formViewInput;

    public function __construct($charset){
        $this->charset = $charset;
    }

    public function Layout($title, $body) {

        return "<!DOCTYPE html>
        <html>
            <head>
                <meta charset=\"" . $this->charset . "\">
                <title>Webagent</title>
            </head>
            <body>
                $body
            </body>
        </html>";
    }

}


<?php

namespace CFW\Interface;

use Exception;

class Display
{
    public function getView()
    {
        $homeURL = $_ENV['HOME_URL'] ?? "index";
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, "/");
        if ($uri == "") :
            $uri = $homeURL;
        endif;
        $url = __DIR__ . $_ENV['PAGES_LOCATION'] . "/{$uri}.php";

        if (file_exists($url)) :
            $this->prepare($url);
        else :
            throw new Exception("View Error: File {$url} does not exist.");
        endif;
    }

    protected function prepare($url)
    {
        ob_start();
        include( __DIR__ . $_ENV['PAGES_LOCATION'] . "/template.php");
        $template = ob_get_clean();

        ob_start();
        include($url);
        $page = ob_get_clean();

        $content = str_replace("[BODY]", $page, $template);
        $this->render($content);
    }

    private function render($content)
    {
        echo $content;
    }
}

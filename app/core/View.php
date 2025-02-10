<?php

namespace App\Core;

use Twig\Environment;
class View
{

    private static $twig;

    public static function setTwig(Environment $twig)
    {
        self::$twig = $twig;
    }

    public static function render($view, $data = [])
    {
        echo self::$twig->render($view . '.twig', $data);
    }
}

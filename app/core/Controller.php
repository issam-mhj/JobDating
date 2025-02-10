<?php

namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        View::render($view, $data);
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getPostData()
    {
        return $_POST;
    }

    protected function validate($data, $rules)
    {
        return Validator::validate($data, $rules);
    }

    protected function isValidCsrfToken($token)
    {
        return Security::verifyCsrfToken($token);
    }
}
<?php
namespace app\Http\Controllers;

class HomeController
{
    public function index()
    {
        return "Welcome to index page";
    }
    public function about()
    {
        return "Welcome to about page";
    }

    public function article($id, $name)
    {
        return "Welcome to article page id = $id / name = $name";
    }
}

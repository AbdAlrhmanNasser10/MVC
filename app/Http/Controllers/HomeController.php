<?php
namespace app\Http\Controllers;

class HomeController
{
    public function index()
    {
        echo "Welcome to index page";
    }
    public function about()
    {
        echo "Welcome to about page";
    }

    public function article($id )
    {
        echo "Welcome to article page id = $id";
    }
}

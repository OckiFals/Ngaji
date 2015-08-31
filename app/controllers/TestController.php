<?php namespace app\controllers;

use Ngaji\Routing\Controller2;

class TestController extends Controller2 {
    // translate to path ""
    public function indexAction() {
        return 'Him';
    }

    // translate to path "/id"
    public function idAction() {
        return 'test id';
    }
}
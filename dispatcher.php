<?php
require(ROOT . 'Models/FirebaseAdmin.php');

class Dispatcher {

    private $request;

    public function dispatch() {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        call_user_func_array([$controller, $this->request->action], $this->request->params);
    }

    public function loadController() {
        $name = $this->request->controller . "Controller";
        $admin = new FirebaseAdmin();
        if (isset(apache_request_headers()['authorization']) && $admin->checkUserValidity(apache_request_headers()['authorization'])) {
            $file = ROOT . 'Controllers/' . $name . '.php';
            require($file);
            $controller = new $name($name == 'terminalController' ? 'default' : 'json', json_decode(file_get_contents("php://input"), true));
        } else {
            http_response_code(401);
            header('Content-Type: application/json');
            echo(json_encode(['error' => 'user not authorized'], true));
            exit(0);
        }
        return $controller;
    }

}

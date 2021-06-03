<?php
require(ROOT . 'Models/Operation.php');

class operationsController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $operation = new Operation();
        $d['result'] = $operation->showAll();
        $this->set($d);
        $this->render('result');
    }

    function create()
    {
        if (!empty($this->json['trip']) && !empty($this->json['type'])) {
            $operation = new Operation();
            $result = $operation->create($this->json);
            if ($result) {
                $d['result'] = ["id" => $result];
                $this->set($d);
                $this->render('result');
            } else {
                http_response_code(406);
            }
        } else {
            http_response_code(400);
        }
    }

    function edit()
    {
        if (!empty($this->json['id']) && !empty($this->json['trip']) && !empty($this->json['trip'])) {
            $operation = new Operation();
            $result = $operation->edit($this->json);
            if ($result) {
                $d['result'] = $this->json;
                $this->set($d);
                $this->render('result');
            } else {
                http_response_code(406);
            }
        } else {
            http_response_code(400);
        }
    }

    function delete()
    {
        if (!empty($this->json['id'])) {
            $operation = new Operation();
            if ($operation->delete($this->json)) {
                $d['result'] = $this->json;
                $this->set($d);
                $this->render('result');
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
    }
}

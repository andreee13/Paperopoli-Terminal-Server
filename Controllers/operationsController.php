<?php
require(ROOT . 'Models/Operation.php');
require(ROOT . 'Models/OperationStatus.php');

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

    function types()
    {
        $ship = new Operation();
        $d['result'] = $ship->showTypes([]);
        $this->set($d);
        $this->render('raw');
    }

    function status_names()
    {
        $ship = new OperationStatus();
        $d['result'] = $ship->showAll([]);
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['trip'])) {
            $operation = new Operation();
            $result = $operation->create($this->json);
            if ($result) {
                http_response_code(200);
            } else {
                http_response_code(406);
            }
        } else {
            http_response_code(400);
        }
    }

    function edit()
    {
        if (!empty($this->json['id']) && !empty($this->json['trip'])) {
            $operation = new Operation();
            $result = $operation->edit($this->json);
            $operationStatus = new OperationStatus();
            foreach ($this->json['status'] as $status) {
                echo json_encode($status);
                if ($status['is_new'] && !$status['is_deleted']) {
                    $status['operation'] = $this->json['id'];
                    $operationStatus->create($status);
                } else if ($status['is_deleted']) {
                    $operationStatus->delete($status);
                }
            }
            if ($result) {
                http_response_code(200);
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

<?php
require(ROOT . 'Models/Ship.php');
require(ROOT . 'Models/ShipStatus.php');

class shipsController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $ship = new Ship();
        $d['result'] = $ship->showAll([]);
        $this->set($d);
        $this->render('result');
    }

    function types()
    {
        $ship = new Ship();
        $d['result'] = $ship->showTypes([]);
        $this->set($d);
        $this->render('raw');
    }

    function status_names()
    {
        $ship = new Ship();
        $d['result'] = $ship->showStatusNames([]);
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['status'])) {
            $ship = new Ship();
            $result = $ship->create($this->json);
            if ($result) {
                $d['result'] = ["id" => $result, "status" => $this->json['status']];
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
        if (!empty($this->json['id'])) {
            $ship = new Ship();
            $result = $ship->edit($this->json);
            $shipStatus = new ShipStatus();
            foreach($this->json['status'] as $status) {
                if($status['is_new'] && !$status['is_deleted']) {
                    $status['ship'] = $this->json['id'];
                    $shipStatus->create($status);
                } else if ($status['is_deleted']) {
                    $shipStatus->delete($status);
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
            $ship = new Ship();
            if ($ship->delete($this->json)) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
    }
}

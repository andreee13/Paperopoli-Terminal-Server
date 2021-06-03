<?php
require(ROOT . 'Models/Vehicle.php');
require(ROOT . 'Models/VehicleStatus.php');

class vehiclesController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $vehicle = new Vehicle();
        $d['result'] = $vehicle->showAll([]);
        $this->set($d);
        $this->render('result');
    }

    function types()
    {
        $ship = new Vehicle();
        $d['result'] = $ship->showTypes([]);
        $this->set($d);
        $this->render('raw');
    }

    function status_names()
    {
        $ship = new Vehicle();
        $d['result'] = $ship->showStatusNames([]);
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['status']) && !empty($this->json['plate'])) {
            $vehicle = new Vehicle();
            $result = $vehicle->create($this->json);
            if ($result) {
                $d['result'] = $this->json;;
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
        if (isset($this->json['id'])) {
            $vehicle = new Vehicle();
            $result = $vehicle->edit($this->json);
            $vehicleStatus = new VehicleStatus();
            foreach ($this->json['status'] as $status) {
                if ($status['is_new'] && !$status['is_deleted']) {
                    $status['vehicle'] = $this->json['id'];
                    $vehicleStatus->create($status);
                } else if ($status['is_deleted']) {
                    $vehicleStatus->delete($status);
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
            $vehicle = new Vehicle();
            if ($vehicle->delete($this->json)) {
                $d['result'] = $this->json;;
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

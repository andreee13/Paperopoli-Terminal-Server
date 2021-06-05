<?php
require(ROOT . 'Models/Trip.php');

class tripsController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $trip = new Trip();
        $d['result'] = $trip->showAll([]);
        $this->set($d);
        $this->render('result');
    }

    function create()
    {
        if (!empty($this->json['arrivo_previsto']) && !empty($this->json['partenza_prevista'])) {
            $trip = new Trip();
            $result = $trip->create($this->json);
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
        if (!empty($this->json['id'])) {
            $trip = new Trip();
            $result = $trip->edit($this->json);
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
            $trip = new Trip();
            if ($trip->delete($this->json)) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
    }
}

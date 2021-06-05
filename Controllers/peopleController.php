<?php
require(ROOT . 'Models/Person.php');
require(ROOT . 'Models/PersonStatus.php');

class peopleController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $person = new Person();
        $d['result'] = $person->showAll([]);
        $this->set($d);
        $this->render('result');
    }

    function types()
    {
        $ship = new Person();
        $d['result'] = $ship->showTypes([]);
        $this->set($d);
        $this->render('raw');
    }

    function status_names()
    {
        $ship = new PersonStatus();
        $d['result'] = $ship->showAll([]);
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['status'])) {
            $person = new Person();
            $personStatus = new PersonStatus();
            $result = $person->create($this->json);
            if ($result) {
                foreach ($this->json['status'] as $status) {
                    $status['person'] = $result;
                    $personStatus->create($status);
                }
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
            $person = new Person();
            $result = $person->edit($this->json);
            $personStatus = new PersonStatus();
            foreach ($this->json['status'] as $status) {
                if ($status['is_new'] && !$status['is_deleted']) {
                    $status['person'] = $this->json['id'];
                    $personStatus->create($status);
                } else if ($status['is_deleted']) {
                    $personStatus->delete($status);
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
            $person = new Person();
            if ($person->delete($this->json)) {
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

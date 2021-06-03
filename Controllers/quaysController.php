<?php
require(ROOT . 'Models/Quay.php');

class quaysController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function show()
    {
        $quay = new Quay();
        $d['result'] = $quay->showView();
        $this->set($d);
        $this->render('result');
    }

    function index()
    {
        $quay = new Quay();
        $d['result'] = $quay->showAll();
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['status'])) {
            $quay = new Quay();
            $result = $quay->create($this->json);
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
        if (!empty($this->json['status']) && !empty($this->json['id']) && !empty($this->json['new_id'])) {
            $quay = new Quay();
            $result = $quay->edit($this->json);
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
            $quay = new Quay();
            if ($quay->delete($this->json)) {
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

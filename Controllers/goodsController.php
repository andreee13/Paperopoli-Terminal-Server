<?php
require(ROOT . 'Models/Good.php');
require(ROOT . 'Models/GoodStatus.php');

class goodsController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        $good = new Good();
        $d['result'] = $good->showAll(['by' => 'ID', 'order' => 'DESC']);
        $this->set($d);
        $this->render('result');
    }

    function types()
    {
        $ship = new Good();
        $d['result'] = $ship->showTypes([]);
        $this->set($d);
        $this->render('raw');
    }

    function status_names()
    {
        $ship = new GoodStatus();
        $d['result'] = $ship->showAll([]);
        $this->set($d);
        $this->render('raw');
    }

    function create()
    {
        if (!empty($this->json['status'])) {
            $good = new Good();
            $goodStatus = new GoodStatus();
            $result = $good->create($this->json);
            if ($result) {
                foreach ($this->json['status'] as $status) {
                    $status['good'] = $result;
                    $goodStatus->create($status);
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
            $good = new Good();
            $result = $good->edit($this->json);
            $goodStatus = new GoodStatus();
            foreach ($this->json['status'] as $status) {
                if ($status['is_new'] && !$status['is_deleted']) {
                    $status['good'] = $this->json['id'];
                    $goodStatus->create($status);
                } else if ($status['is_deleted']) {
                    $goodStatus->delete($status);
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
            $good = new Good();
            if ($good->delete($this->json)) {
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

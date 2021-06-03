<?php
require(ROOT . 'Models/User.php');

class usersController extends Controller
{

    private $json;

    function __construct($layout, $json)
    {
        $this->json = $json;
        parent::__construct($layout);
    }

    function index()
    {
        if (isset($this->json['name']) && isset($this->json['email']) && isset($this->json['metadata'])) {
            $user = new User();
            $result = $user->check($this->json);
            if (!empty($result)) {
                $_SESSION['USER'] = $result[0];
            } else {
                http_response_code(403);
            }
        } else {
            http_response_code(400);
        }
    }

    function create()
    {
        if (!empty($this->json['email']) && !empty($this->json['name']) && !empty($this->json['metadata'])) {
            $user = new User();
            $result = $user->create($this->json);
            if ($result) {
                //todo: valid true
            } else {
                http_response_code(403);
            }
        } else {
            http_response_code(400);
        }
    }
}

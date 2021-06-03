<?php
    class Controller {
        var $vars = [];
        var $layout;

        public function __construct($layout)
        {
            $this->layout = $layout;       
        }

        function changeLayout($layout)
        {
            $this->layout = $layout;  
        }

        function set($d) {
            $this->vars = array_merge($this->vars, $d);
        }

        function render($filename) {
            extract($this->vars);
            ob_start();
            require(ROOT . "Views/" . str_replace('Controller', '', get_class($this))) . '/' . $filename . '.php';
            $content_for_layout = ob_get_clean();
            if ($this->layout == false) {
                $content_for_layout;
            } else {
                require(ROOT . "Views/Layouts/" . $this->layout . '.php');
            }
        }

        private function secure_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        protected function secure_form($form) {
            foreach ($form as $key => $value) {
                $form[$key] = $this->secure_input($value);
            }
        }

    }

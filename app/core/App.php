<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];


    public function __construct()
    {
        $url = $this->parseURL();
        // controller
        // mengecek file ada atau tidak, dari url ke controllers
        if( file_exists('../app/controllers/' . $url[0] . '.php') ) {
            $this->controller = $url[0];
            unset($url[0]); // menghapus url index kesatu yaitu home
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // method
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // params
        if( !empty($url) ) {
            $this->params = array_values($url);
        }

        // jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);

    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/'); //membersihkan tanda '/' diakhir urlnya
            $url = filter_var($url, FILTER_SANITIZE_URL); //membersihkan url dari karakter aneh/ngaco
            $url = explode('/', $url); //memecah url berdasarkan tanda '/', stringnya berubah menjadi elemen array
            return $url;
        }
    }
}

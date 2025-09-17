<?php
// app/core/Router.php

class Router {
    private $routes = [];

    public function __construct() {
        // ... (el mismo código de rutas) ...
        $this->addRoute('/', 'Auth@showLogin');
        $this->addRoute('/login', 'Auth@login');
        $this->addRoute('/dashboard', 'Dashboard@index');
        $this->addRoute('/logout', 'Auth@logout');
        $this->addRoute('/pao/create', 'Pao@create');
        $this->addRoute('/pao/store', 'Pao@store');
        $this->addRoute('/professor/profile', 'Professor@showProfile');
        $this->addRoute('/professor/update', 'Professor@updateProfile');
    }

    public function addRoute($url, $controllerMethod) {
        $this->routes[$url] = $controllerMethod;
    }

    public function dispatch() {
        // Obtiene la URL de la petición y elimina la ruta base
        $requestUri = $_SERVER['REQUEST_URI'];
        $basePath = BASE_PATH;

        if (strpos($requestUri, $basePath) === 0) {
            $url = substr($requestUri, strlen($basePath));
        } else {
            $url = $requestUri;
        }

        // Limpia la URL de parámetros de consulta y barras
        $url = trim(parse_url($url, PHP_URL_PATH), '/');
        $url = empty($url) ? '/' : '/' . $url;

        // ... (el resto del código del enrutador sigue igual) ...
        if (array_key_exists($url, $this->routes)) {
            list($controller, $method) = explode('@', $this->routes[$url]);
            $controllerFile = __DIR__ . '/../controllers/' . $controller . 'Controller.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = $controller . 'Controller';
                if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                    $instance = new $controllerClass();
                    $instance->$method();
                } else {
                    $this->handleNotFound();
                }
            } else {
                $this->handleNotFound();
            }
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound() {
        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>La página que buscas no existe.</p>";
    }
}
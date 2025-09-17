<?php
// app/core/Router.php

class Router {
    private $routes = [];

    public function __construct() {
        // Rutas de autenticación
        $this->addRoute('/', 'Auth@showLogin');
        $this->addRoute('/login', 'Auth@login');
        $this->addRoute('/register', 'Auth@showRegister');
        $this->addRoute('/register/store', 'Auth@register');
        $this->addRoute('/logout', 'Auth@logout');

        // Rutas del Dashboard
        $this->addRoute('/dashboard', 'Dashboard@index');

        // Rutas de gestión de PAO
        $this->addRoute('/pao', 'Pao@index');
        $this->addRoute('/pao/create', 'Pao@create');
        $this->addRoute('/pao/store', 'Pao@store');

        // Rutas de gestión de Perfil de Profesor
        $this->addRoute('/professor/profile', 'Professor@showProfile');
        $this->addRoute('/professor/save-cv', 'Professor@saveCv');
        
        // Rutas de gestión de usuarios (Super Administrador)
        $this->addRoute('/users', 'User@index');
        $this->addRoute('/users/edit', 'User@edit'); // Nota: la lógica de edición necesitaría manejar un ID en la URL.
        $this->addRoute('/users/update', 'User@update');

        // Rutas de gestión de Portafolios
        $this->addRoute('/portfolios', 'Portfolio@index');
        $this->addRoute('/portfolios/upload', 'Portfolio@upload');

        // Rutas de gestión de Evaluaciones
        $this->addRoute('/evaluations', 'Evaluation@index');
        $this->addRoute('/evaluations/create', 'Evaluation@create');
        $this->addRoute('/evaluations/store', 'Evaluation@store');

        // Rutas de gestión de Continuidad
        $this->addRoute('/continuity', 'Continuity@index');
        $this->addRoute('/continuity/decide', 'Continuity@decide');

        // Rutas de gestión de Contratos
        $this->addRoute('/contracts', 'Contract@index');
        $this->addRoute('/contracts/upload', 'Contract@upload');
        
        // Rutas de gestión de Facturas
        $this->addRoute('/invoices', 'Invoice@index');
        $this->addRoute('/invoices/store', 'Invoice@store');

        // Rutas de gestión académica (Carreras, Asignaturas, Asignaciones)
        $this->addRoute('/academic/careers', 'Academic@careers');
        $this->addRoute('/academic/subjects', 'Academic@subjects');
        $this->addRoute('/academic/assignments', 'Academic@assignments');
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
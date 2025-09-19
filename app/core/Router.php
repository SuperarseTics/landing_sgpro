<?php
// app/core/Router.php

class Router
{
    private $routes = [];

    public function __construct()
    {
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
        $this->addRoute('/users/create', 'User@create');
        $this->addRoute('/users/store', 'User@store');
        $this->addRoute('/users/edit/{id}', 'User@edit');
        $this->addRoute('/users/update/{id}', 'User@update');
        $this->addRoute('/users/delete/{id}', 'User@delete');

        // Rutas de gestión de Portafolios
        $this->addRoute('/portfolios', 'Portfolio@index');
        $this->addRoute('/portfolios/upload', 'Portfolio@upload');

        // Rutas de gestión de Evaluaciones
        $this->addRoute('/evaluations', 'Evaluation@index');
        $this->addRoute('/evaluations/create', 'Evaluation@create');
        $this->addRoute('/evaluations/store', 'Evaluation@store');
        $this->addRoute('/evaluations/edit/{id}', 'Evaluation@edit'); 
        $this->addRoute('/evaluations/update/{id}', 'Evaluation@update');

        // Rutas de gestión de Continuidad
        $this->addRoute('/continuity', 'Continuity@index');
        $this->addRoute('/continuity/create', 'Continuity@create');
        $this->addRoute('/continuity/store', 'Continuity@store');
        $this->addRoute('/continuity/edit/{id}', 'Continuity@edit');
        $this->addRoute('/continuity/update/{id}', 'Continuity@update');

        // Rutas de gestión de Contratos
        $this->addRoute('/contracts', 'Contract@index');
        $this->addRoute('/contracts/create', 'Contract@create');
        $this->addRoute('/contracts/store', 'Contract@store');
        $this->addRoute('/contracts/edit/{id}', 'Contract@edit');
        $this->addRoute('/contracts/update/{id}', 'Contract@update');

        // Rutas de gestión de Facturas
        $this->addRoute('/invoices', 'Invoice@index');
        $this->addRoute('/invoices/create', 'Invoice@create');
        $this->addRoute('/invoices/store', 'Invoice@store');
        $this->addRoute('/invoices/edit/{id}', 'Invoice@edit');
        $this->addRoute('/invoices/update/{id}', 'Invoice@update');

        // Rutas de gestión de Asignaciones
        $this->addRoute('/academic/assignments', 'Assignment@index');
        $this->addRoute('/academic/assignments/create', 'Assignment@create');
        $this->addRoute('/academic/assignments/store', 'Assignment@store');
        $this->addRoute('/academic/assignments/edit/{id}', 'Assignment@edit');
        $this->addRoute('/academic/assignments/update/{id}', 'Assignment@update');

        // Rutas de gestión de Carreras
        $this->addRoute('/academic/careers', 'Career@index');
        $this->addRoute('/academic/careers/store', 'Career@store');
        $this->addRoute('/academic/careers/edit/{id}', 'Career@edit');
        $this->addRoute('/academic/careers/update/{id}', 'Career@update');
        $this->addRoute('/academic/careers/quick-store', 'Career@quickStore');

        // Rutas de gestión de Asignaturas
        $this->addRoute('/academic/subjects', 'Subject@index');
        $this->addRoute('/academic/subjects/create', 'Subject@create');
        $this->addRoute('/academic/subjects/store', 'Subject@store');
        $this->addRoute('/academic/subjects/edit/{id}', 'Subject@edit');
        $this->addRoute('/academic/subjects/update/{id}', 'Subject@update');
    }

    public function addRoute($url, $controllerMethod)
    {
        $this->routes[$url] = $controllerMethod;
    }

    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $basePath = BASE_PATH;

        if (strpos($requestUri, $basePath) === 0) {
            $url = substr($requestUri, strlen($basePath));
        } else {
            $url = $requestUri;
        }

        $url = trim(parse_url($url, PHP_URL_PATH), '/');
        $url = empty($url) ? '/' : '/' . $url;

        $found = false;
        $params = [];

        foreach ($this->routes as $routeUrl => $controllerMethod) {
            // Reemplazar {id} por un patrón de regex
            $pattern = preg_replace('/{[a-zA-Z0-9]+}/', '([a-zA-Z0-9]+)', $routeUrl);
            $pattern = str_replace('/', '\/', $pattern);

            if (preg_match("/^$pattern$/", $url, $matches)) {
                array_shift($matches); // Eliminar el primer elemento (la URL completa)
                $params = $matches;
                list($controller, $method) = explode('@', $controllerMethod);
                $found = true;
                break;
            }
        }

        if ($found) {
            $controllerFile = __DIR__ . '/../controllers/' . $controller . 'Controller.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = $controller . 'Controller';
                if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                    $instance = new $controllerClass();
                    call_user_func_array([$instance, $method], $params);
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

    private function handleNotFound()
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>La página que buscas no existe.</p>";
    }
}

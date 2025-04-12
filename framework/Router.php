<?php

namespace Framework;

use Framework\Middleware\Authorize;

class Router
{
  protected $routes = [];

  private function register_route(string $method, string $uri, string $action, array $middleware = []): void
  {
    list($controller, $controller_method) = explode("@", $action);
    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller,
      'controller_method' => $controller_method,
      'middleware' => $middleware
    ];
  }

  public function get(string $uri, string $controller, array $middleware = []): void
  {
    $this->register_route('GET', $uri, $controller, $middleware);
  }

  public function post(string $uri, string $controller, array $middleware = []): void
  {
    $this->register_route('POST', $uri, $controller, $middleware);
  }

  public function put(string $uri, string $controller, array $middleware = []): void
  {
    $this->register_route('PUT', $uri, $controller, $middleware);
  }

  public function delete(string $uri, string $controller, array $middleware = []): void
  {
    $this->register_route('DELETE', $uri, $controller, $middleware);
  }

  public function route(string $req_uri): void
  {
    $req_method = $_SERVER['REQUEST_METHOD'];

    // check for _method hidden input
    if ($req_method === "POST" and isset($_POST['_method'])) {
      // override the request method
      $req_method = strtoupper($_POST['_method']);
    }

    foreach ($this->routes as $r) {
      // split the current URI into segments
      $uri_segments = explode("/", trim($req_uri, "/"));

      // split the route URI into segments
      $route_segments = explode("/", trim($r['uri'], '/'));

      // $match = true;



      // check if the number of segments match
      if (
        count($uri_segments) == count($route_segments) and
        strtoupper($r['method']) == $req_method
      ) {
        $params = [];

        $match = true;
        $params_regex = "/\{(.+?)\}/";

        for ($i = 0; $i < count($uri_segments); $i++) {

          // break and leave if the URIs do *not* match and no param is there
          if (
            $route_segments[$i] != $uri_segments[$i] and
            !preg_match($params_regex, $route_segments[$i])
          ) {
            $match = false;
            break;
          }

          // match and set the param to its value
          // ? example: in `/path/to/{here}` -> $params['here'] = its value
          if (preg_match($params_regex, $route_segments[$i], $matches)) {
            $params[$matches[1]] = $uri_segments[$i];
          }
        }

        // load the controller and pass in params if everything is matched
        if ($match) {
          // extract middleware
          foreach ($r['middleware'] as $role) {
            (new Authorize())->handle($role);
          }

          $controller_file = 'app/controllers/' . $r['controller'] . '.php';

          if (file_exists($controller_file)) {
            require $controller_file;  // Include the controller file manually
          } else {
            die("Controller file not found: " . $controller_file); // Handle error properly
          }

          // Extract controller and controller method
          $controller_class = 'app\\controllers\\' . $r['controller']; // Use namespace-compatible class name
          $controller_method = $r['controller_method'];

          // Check if class exists after requiring it
          if (class_exists($controller_class)) {
            $controller_instance = new $controller_class;
            $controller_instance->$controller_method($params);
          } else {
            die("Controller class not found: " . $controller_class);
          }
        }
      }
    }

    // TODO: mind you if you have time for this???????
    // load the 404 if the uri and/or method doesn't found
    // ErrorController::not_found();
  }
}

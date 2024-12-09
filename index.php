<?php

// Code Below is for routing but not yet finished 
// $url = $_SERVER['REQUEST_URI'];
// $path = parse_url($url)['path'];

// echo '<pre>';
// var_dump($_SERVER);
// echo  '</pre>';
// $routes = [
//   '/' => 'login.php',
//   // '/login' => 'loginController.php',
// ];

// if (array_key_exists($path, $routes)) {
//   // Include the corresponding controller based on the route
//   $controller = $routes[$path];
//   // require "controllers/{$controller}";
//   require "{$controller}";
// } else {
//   http_response_code(404);
//   echo 'Page not found';
// }

//requires login.php so it /tutorhouse/ redirects to login.php

require 'login.php';

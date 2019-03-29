<?php
  require_once __DIR__ . '/Request.php';
  require_once  __DIR__ . '/Router.php';

  session_start();

  $request = new Request();
  $router = new Router($request);

  $_SESSION['router'] = isset($_SESSION['router']) ? $_SESSION['router'] : $router;

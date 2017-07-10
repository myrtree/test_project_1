<?php

return array (
  1 => 
  array (
    'pattern' => '',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'index',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  2 => 
  array (
    'pattern' => 'login',
    'handler' => 
    array (
      0 => 'UserController',
      1 => 'loginForm',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  3 => 
  array (
    'pattern' => 'checkuser',
    'handler' => 
    array (
      0 => 'UserController',
      1 => 'logIn',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  4 => 
  array (
    'pattern' => 'logout',
    'handler' => 
    array (
      0 => 'UserController',
      1 => 'logOut',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  5 => 
  array (
    'pattern' => 'tasks',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'index',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  6 => 
  array (
    'pattern' => 'tasks/page/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'index',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'page',
    ),
  ),
  7 => 
  array (
    'pattern' => 'tasks/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'view',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'id',
    ),
  ),
  8 => 
  array (
    'pattern' => 'tasks/create',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'create',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  9 => 
  array (
    'pattern' => 'tasks/store',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'store',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  10 => 
  array (
    'pattern' => 'tasks/edit/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'edit',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'id',
    ),
  ),
  11 => 
  array (
    'pattern' => 'tasks/update/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'update',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'id',
    ),
  ),
  12 => 
  array (
    'pattern' => 'tasks/destroy/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'destroy',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'id',
    ),
  ),
  13 => 
  array (
    'pattern' => 'tasks/setstatus/(\\d+)',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'setStatus',
    ),
    'varsCount' => 1,
    'varNames' => 
    array (
      0 => 'id',
    ),
  ),
  14 => 
  array (
    'pattern' => 'tasks/preview',
    'handler' => 
    array (
      0 => 'TaskController',
      1 => 'preview',
    ),
    'varsCount' => 0,
    'varNames' => 
    array (
    ),
  ),
  'regex' => '~^(?||login()|checkuser()()|logout()()()|tasks()()()()|tasks/page/(\\d+)()()()()|tasks/(\\d+)()()()()()|tasks/create()()()()()()()|tasks/store()()()()()()()()|tasks/edit/(\\d+)()()()()()()()()|tasks/update/(\\d+)()()()()()()()()()|tasks/destroy/(\\d+)()()()()()()()()()()|tasks/setstatus/(\\d+)()()()()()()()()()()()|tasks/preview()()()()()()()()()()()()())$~x',
);

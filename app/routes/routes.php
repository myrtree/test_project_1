<?php

return [
    '' => ['TaskController', 'index'],

    'login' => ['UserController', 'loginForm'],
    'checkuser' => ['UserController', 'logIn'],
    'logout' => ['UserController', 'logOut'],

    'tasks' => ['TaskController', 'index'],
    'tasks/page/{page:\d+}' => ['TaskController', 'index'],
    'tasks/{id:\d+}' => ['TaskController', 'view'],
    'tasks/create' => ['TaskController', 'create'],
    'tasks/store' => ['TaskController', 'store'],
    'tasks/edit/{id:\d+}' => ['TaskController', 'edit'],
    'tasks/update/{id:\d+}' => ['TaskController', 'update'],
    'tasks/destroy/{id:\d+}' => ['TaskController', 'destroy'],
    'tasks/setstatus/{id:\d+}' => ['TaskController', 'setStatus'],
    'tasks/preview' => ['TaskController', 'preview']
];

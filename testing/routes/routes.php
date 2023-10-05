<?php

use CFW\Interface\Dispatcher;

Dispatcher::add_route('GET', '', 'CFW\\Interface\\Display@getView');
Dispatcher::add_route('GET', '/', 'CFW\\Interface\\Display@getView');
Dispatcher::add_route('GET', '/index', 'CFW\\Interface\\Display@getView');

Dispatcher::add_route('GET', '/test', 'CFW\\Interface\\Display@getView');

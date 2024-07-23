<?php

namespace Src\Api;
class Route {

    public function __construct(public $path, public $action, public $requestMethod) {
    }
}

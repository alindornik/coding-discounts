<?php

namespace Src\Api\Routing;
class Route {

    public function __construct(public $path, public $action, public $requestMethod) {
    }
}

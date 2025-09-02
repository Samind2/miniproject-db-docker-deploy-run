<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Routing extends BaseConfig
{
    /**
     * Enable auto routing (Improved).
     */
    public bool $autoRoute = false;
    public string $defaultNamespace = 'App\\Controllers';
    public string $defaultController = 'Home';
    public string $defaultMethod = 'index';
    public bool $translateURIDashes = false;
    public $override404 = null;
    public array $routeFiles = [];
    public bool $prioritize = false;
    public bool $multipleSegmentsOneParam = false;
}

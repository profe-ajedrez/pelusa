<?php declare(strict_types=1);

namespace vso\pelusa\app;

use vso\app\app;
use vso\app\InterfaceAppInitializer;
use vso\app\InterfaceLoadEnvironment;
use vso\app\InterfaceApp;
use vso\http\request\BaseRequest;
use vso\mailcontainer\NativeMailContainer;
use vso\http\router\BaseRouter;
use vso\http\router\resolver\RestfulResolver;

class PelusaInitializer implements InterfaceAppInitializer
{
    public InterfaceLoadEnvironment $envLoader;

    public function __construct(InterfaceLoadEnvironment $loadEnv)
    {
        $this->envLoader = $loadEnv;
    }

    /**
     * initialize
     * @overwrites vso\app\AppInitializer::initialize()
     *
     * @param App $application
     * @return void
     */
    public function initialize(InterfaceApp $application) : void
    {
        $this->envLoader->load();
        
        $application->setWhooper(new \Whoops\Run());
        $application->setLogger(new \Monolog\Logger('applog'));
        $application->setMailContainer(new NativeMailContainer());

        $request      = new BaseRequest($_SERVER);
        $resolverRest = new RestfulResolver();
        $application->setRouter(new BaseRouter($request, $resolverRest));
    }
}

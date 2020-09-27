<?php declare(strict_types=1);

namespace vso\pelusa\app;

use vso\app\InterfaceApp;
use \vso\mailcontainer\InterfaceMailContainer;
use \vso\app\InterfaceAppInitializer;
use \Monolog\Logger;
use \Whoops\Run;
use \vso\http\router\InterfaceRouter;

class Pelusa implements InterfaceApp
{
    protected InterfaceMailContainer $mailContainer;
    protected Logger $logger;
    protected Run $whooper;
    protected InterfaceRouter $router;

    public function __construct(
        InterfaceAppInitializer $pelusaInitializer
    ) {
        /** We delegate in PelusaInitialize the bootstraping of app */
        if (is_null($pelusaInitializer)) {
            throw new \InvalidArgumentException(
                'Expecting an AppInitializer. Null or empty received in ' . __CLASS__ . '::' . __METHOD__
            );
        }

        $pelusaInitializer->initialize($this);
    }

    public function __get(string $property)
    {
        $returnable = null;
        switch ($property) {
            case 'logger':
                $returnable = $this->logger;
                break;
            case 'whooper':
                $returnable = $this->whooper;
                break;
            case 'router':
                $returnable = $this->router;
                break;
            case 'mailContainer':
                $returnable = $this->mailContainer;
                break;
            default:
                throw new \InvalidArgumentException('Property ' . $property . ' doesnt exists in ' . __CLASS__);
        }

        return $returnable;
    }

    public function getLogger() : Logger
    {
        return $this->logger;
    }

    public function getWhooper() : Run
    {
        return $this->whooper;
    }

    public function getRouter() : InterfaceRouter
    {
        return $this->router;
    }

    public function getMailContainer() : InterfaceMailContainer
    {
        return $this->mailContainer;
    }

    public function setLogger(logger $logger) : void
    {
        $this->logger = $logger;
    }

    public function setWhooper(Run $whooper) : void
    {
        $this->whooper = $whooper;
    }

    public function setRouter(InterfaceRouter $router) : void
    {
        $this->router = $router;
    }

    public function setMailContainer(InterfaceMailContainer $mailContainer) : void
    {
        $this->mailContainer = $mailContainer;
    }
}

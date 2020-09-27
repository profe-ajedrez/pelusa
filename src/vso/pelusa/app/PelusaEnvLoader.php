<?php declare(strict_types=1);

namespace vso\pelusa\app;

use Dotenv\Dotenv;
use vso\app\InterfaceLoadEnvironment;

class PelusaEnvLoader implements InterfaceLoadEnvironment
{
    private \Closure $onEnvLoading;
    private string $envFileName;
    private string $envFilePath;

    public function __construct(string $envFilePath, string $envFileName, \Closure $onEnvLoading = null)
    {
        if (empty($envFilePath)) {
            throw new \InvalidArgumentException(
                'Expecting a string environment file path. Null or empty received in ' . __CLASS__ . '::' . __METHOD__
            );
        }

        if (empty($envFileName)) {
            throw new \InvalidArgumentException(
                'Expecting a string environment file name. Null or empty received in ' . __CLASS__ . '::' . __METHOD__
            );
        }

        if (is_null($onEnvLoading)) {
            $onEnvLoading = function () {
            };
        }
        $this->envFileName  = $envFileName;
        $this->envFilePath  = $envFilePath;
        $this->onEnvLoading = $onEnvLoading;
    }
    
    /**
     * load
     * @overwrites vso\app\EnvironmentLoaderExample::load()
     *
     * @return void
     */
    public function load() : void
    {
        $dotEnv = \Dotenv\Dotenv::createImmutable($this->envFilePath, $this->envFileName);
        /**
         * Put here the list of required environment variables
         * also the validation rules as told in https://github.com/vlucas/phpdotenv
         */
        $dotEnv->load();
        $dotEnv->required('DRIVER')->notEmpty();
        $dotEnv->required('USER')->notEmpty();
        $dotEnv->required('PASSWORD')->notEmpty();
        $dotEnv->required('SERVER')->notEmpty();
        $dotEnv->required('DATABASE')->notEmpty();
        $dotEnv->required('LOGS_PATH')->notEmpty();
        $dotEnv->required('DEBUG')->notEmpty();
        $dotEnv->required('HOST')->notEmpty();

        $hookOnLoading = $this->onEnvLoading;
        $hookOnLoading();
    }
}

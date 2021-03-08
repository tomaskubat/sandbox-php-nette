<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;
use Tester\Environment;


class Bootstrap
{
	public static function boot(): Configurator
	{
        $appDir = dirname(__DIR__);
        $sapi = PHP_SAPI == 'cli' ? 'cli' : 'web';
        $dev = getenv('ENV', true) === 'development';

        $configurator = new Configurator();
        $configurator->setDebugMode($dev);
		$configurator->enableTracy($appDir . '/log/' . $sapi);

		$configurator->setTempDirectory($appDir . '/tmp/' . $sapi);

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator
			->addConfig($appDir . '/app/Config/common.neon')
			->addConfig($appDir . '/app/Config/local.neon');

		return $configurator;
	}


	public static function bootForTests(): Configurator
	{
		$configurator = self::boot();
		Environment::setup();
		return $configurator;
	}
}

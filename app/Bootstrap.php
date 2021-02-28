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
        $dev = file_exists( $appDir . '/docker-compose.yml');

        $configurator = new Configurator();
        $configurator->setDebugMode($dev);
		$configurator->enableTracy($appDir . '/log/' . $sapi);

		//$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/tmp/' . $sapi);

		$aa = date_default_timezone_get();
        $aaa = date(DATE_RFC2822);

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

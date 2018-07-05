<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/AuthorStub.php';

define('SRC_DIR', realpath(__DIR__ . '/../src'));

// https://github.com/nette/di/blob/master/tests/bootstrap.php
// create temporary directory
define('TEMP_DIR', __DIR__ . '/tmp/' . lcg_value());
@mkdir(dirname(TEMP_DIR));
@mkdir(TEMP_DIR);

function createContainer($source, $config = null, $params = []): ?Nette\DI\Container
{
	$class = 'Container' . md5((string) lcg_value());
	if ($source instanceof Nette\DI\ContainerBuilder) {
		$code = implode('', (new Nette\DI\PhpGenerator($source))->generate($class));
	} elseif ($source instanceof Nette\DI\Compiler) {
		if (is_string($config)) {
			$loader = new Nette\DI\Config\Loader;
			$config = $loader->load(is_file($config) ? $config : Tester\FileMock::create($config, 'neon'));
		}
		$code = $source->addConfig((array) $config)
					   ->setClassName($class)
					   ->compile();
	} else {
		return null;
	}
	file_put_contents(TEMP_DIR . '/code.php', "<?php\n\n$code");
	require TEMP_DIR . '/code.php';
	return new $class($params);
}

<?php declare(strict_types=1);

/**
 * Test: JedenWeb\AuditableModule\DI\AuditableExtension.
 *
 * @testCase Tests\JedenWeb\AuditableModule\DI\AuditableExtensionTest
 * @author Pavel Jurásek
 * @package JedenWeb\AuditableModule\DI
 */

namespace Tests\JedenWeb\AuditableModule\DI;

use JedenWeb\AuditableModule\AdminModule\AuditLog\IAuditLog;
use JedenWeb\AuditableModule\DI\AuditableExtension;
use Nette\DI\Compiler;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class AuditableExtensionTest extends Tester\TestCase
{

	public function testBasic()
	{
		$compiler = new Compiler();
		$compiler->addExtension('auditable', new AuditableExtension);

		$container = createContainer($compiler);

		Assert::true($container->hasService('auditable.auditLog'));
		Assert::type(IAuditLog::class, $container->getService('auditable.auditLog'));
	}

}

(new AuditableExtensionTest())->run();

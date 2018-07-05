<?php

/**
 * Test: JedenWeb\AuditableModule\Model\AuditMessage.
 *
 * @testCase Tests\JedenWeb\AuditableModule\Model\AuditMessageTest
 * @author Pavel Jurásek
 * @package JedenWeb\AuditableModule\Model
 */

namespace Tests\JedenWeb\AuditableModule\Model;

use JedenWeb\AuditableModule\Model\AuditMessage;
use Ramsey\Uuid\UuidInterface;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @author Pavel Jurásek
 */
class AuditMessageTest extends Tester\TestCase
{

	public function testBasic()
	{
		$auditMessage = new AuditMessage('Message');

		Assert::type(UuidInterface::class, $auditMessage->getId());
		Assert::type(\DateTime::class, $auditMessage->getCreatedAt());
		Assert::null($auditMessage->getCreatedBy());
	}

}

(new AuditMessageTest())->run();

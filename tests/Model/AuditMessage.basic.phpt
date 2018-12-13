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
use JedenWeb\AuditableModule\Model\IAuthor;
use Ramsey\Uuid\UuidInterface;
use Tester;
use Tester\Assert;
use Tests\JedenWeb\AuditableModule\AuthorStub;

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

		$auditMessage2 = new AuditMessage('Action was performed.', 'danger', new AuthorStub);

		Assert::same('danger', $auditMessage2->getType());
		Assert::type(IAuthor::class, $auditMessage2->getCreatedBy());
		Assert::same('Author 1', $auditMessage2->getCreatedBy()->getAuditCaption());
	}

}

(new AuditMessageTest())->run();

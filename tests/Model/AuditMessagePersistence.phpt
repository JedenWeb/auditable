<?php

/**
 * Test: JedenWeb\AuditableModule\Model\AuditMessage.
 *
 * @testCase Tests\JedenWeb\AuditableModule\Model\AuditMessageTest
 * @author Pavel Jurásek
 * @package JedenWeb\AuditableModule\Model
 */

namespace Tests\JedenWeb\AuditableModule\Model;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use JedenWeb\AuditableModule\Model\AuditMessage;
use JedenWeb\AuditableModule\Model\IAuthor;
use Nette\Neon\Neon;
use Ramsey\Uuid\UuidInterface;
use Tester;
use Tester\Assert;
use Tests\JedenWeb\AuditableModule\AuthorStub;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @author Pavel Jurásek
 */
class AuditMessagePersistenceTest extends Tester\TestCase
{

	/** @var array */
	private $dbParams;

	/** @var EntityManager */
	private $entityManager;

	/** @var ClassMetadata[] */
	private $metadata;

	/** @var SchemaTool */
	private $schemaTool;

	protected function setUp()
	{
		Tester\Environment::lock('database', TEMP_DIR);

		$configFile = is_file(__DIR__ . '/../database.neon') ? __DIR__ . '/../database.neon' : __DIR__ . '/../database.sample.neon';

		$this->dbParams = Neon::decode(file_get_contents($configFile));

		\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
		$config = Setup::createAnnotationMetadataConfiguration([SRC_DIR], true, null, null, false);
		$config->setNamingStrategy(new UnderscoreNamingStrategy);
		$this->entityManager = EntityManager::create($this->dbParams, $config);

		$listener = new ResolveTargetEntityListener;
		$listener->addResolveTargetEntity(IAuthor::class, AuthorStub::class, []);
		$this->entityManager->getEventManager()->addEventListener(Events::loadClassMetadata, $listener);

		$this->metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
		$this->schemaTool = new SchemaTool($this->entityManager);

		$this->schemaTool->dropSchema($this->metadata);
		$this->schemaTool->createSchema($this->metadata);
	}

	public function testPersistence()
	{
		$auditMessage = new AuditMessage('Persisted message');

		Assert::type(UuidInterface::class, $auditMessage->getId());

		$this->entityManager->persist($auditMessage);
		$this->entityManager->flush();

		$obtained = $this->entityManager->find(AuditMessage::class, $auditMessage->getId());

		Assert::same($auditMessage, $obtained);
	}

	protected function tearDown()
	{
		$this->schemaTool->dropSchema($this->metadata);
	}

}

(new AuditMessagePersistenceTest())->run();

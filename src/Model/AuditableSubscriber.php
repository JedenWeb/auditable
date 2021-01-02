<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

class AuditableSubscriber implements EventSubscriber
{

	public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
	{
		/** @var ClassMetadata $meta */
		$meta = $args->getClassMetadata();

		// apply only to the root of entity hierarchy
		if (!$this->isAuditable($meta) || $meta->isMappedSuperclass || $meta->rootEntityName !== $meta->name) {
			return;
		}

		$namingStrategy = $args
			->getEntityManager()
			->getConfiguration()
			->getNamingStrategy()
		;

		$meta->mapManyToMany([
			'targetEntity'  => AuditMessage::class,
			'fieldName' => 'auditMessages',
			'cascade' => ['persist'],
			'joinTable' => [
				'name' => strtolower($namingStrategy->classToTableName($meta->getName())) . '_audit_messages',
				'joinColumns' => [
					[
						'name' => $namingStrategy->joinKeyColumnName($meta->getName()),
						'referencedColumnName' => $namingStrategy->referenceColumnName(),
						'onDelete' => 'CASCADE',
						'onUpdate' => 'CASCADE',
					],
				],
				'inverseJoinColumns' => [
					[
						'name' => 'audit_message_id',
						'referencedColumnName' => $namingStrategy->referenceColumnName(),
						'onDelete' => 'CASCADE',
						'onUpdate' => 'CASCADE',
					],
				]
			],
			'orderBy' => [
				'createdAt' => 'DESC',
			],
		]);
	}

	private function isAuditable(ClassMetadata $meta): bool
	{
		return in_array(IAuditable::class, (array) class_implements($meta->getName()), true);
	}

	/** @return string[] */
	public function getSubscribedEvents()
	{
		return [
			Events::loadClassMetadata,
		];
	}

}

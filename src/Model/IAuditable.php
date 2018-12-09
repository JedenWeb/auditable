<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

interface IAuditable
{

	public function addAuditMessage(string $message, string $type = 'info', IAuthor $createdBy = null): void;

	public function addAuditMessageEntity(AuditMessage $auditMessage): void;

	/** @return AuditMessage[] */
	public function getAuditMessages(): array;

}

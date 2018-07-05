<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

interface IAuditable
{

	public function addAuditMessage(AuditMessage $auditMessage): void;

	/** @return AuditMessage[] */
	public function getAuditMessages(): array;

}

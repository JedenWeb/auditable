<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\AdminModule\AuditLog;

use JedenWeb\AuditableModule\Model\IAuditable;

interface IAuditLog
{

	public function create(IAuditable $auditable): AuditLog;

}

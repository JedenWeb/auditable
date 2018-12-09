<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait TAuditable
{

	/** @var Collection */
	protected $auditMessages;

	public function addAuditMessage(string $message, string $type = 'info', IAuthor $createdBy = null): void
	{
		$this->addAuditMessageEntity(new AuditMessage($message, $type, $createdBy));
	}

	public function addAuditMessageEntity(AuditMessage $auditMessage): void
	{
		if ($this->auditMessages === null) {
			$this->auditMessages = new ArrayCollection;
		}

		$this->auditMessages->add($auditMessage);
	}

	/** @return AuditMessage[] */
	public function getAuditMessages(): array
	{
		return $this->auditMessages === null ? [] : $this->auditMessages->toArray();
	}

}

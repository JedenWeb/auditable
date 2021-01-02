<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

interface IAuthor
{

    /** @return mixed */
	public function getId();

	public function getAuditCaption(): string;

}

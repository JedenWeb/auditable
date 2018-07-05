<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\DI;

use JedenWeb\AuditableModule\AdminModule\AuditLog\IAuditLog;
use JedenWeb\AuditableModule\Model\AuditableSubscriber;
use Nette\DI\CompilerExtension;

class AuditableExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('auditableSubscriber'))
			->setType(AuditableSubscriber::class)
			->addTag('kdyby.subscriber');

		$container->addDefinition($this->prefix('auditLog'))
			->setImplement(IAuditLog::class);
	}

}

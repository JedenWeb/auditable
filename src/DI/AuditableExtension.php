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

		if (\method_exists($container, 'addFactoryDefinition')) {
		    $def = $container->addFactoryDefinition($this->prefix('auditLog'));
        } else {
            $def = $container->addDefinition($this->prefix('auditLog'));
        }

        $def->setImplement(IAuditLog::class);
	}

}

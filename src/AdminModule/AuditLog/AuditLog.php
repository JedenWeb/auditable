<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\AdminModule\AuditLog;

use JedenWeb\AuditableModule\Model\IAuditable;
use JedenWeb\AuditableModule\TemplateNotFoundException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

/**
 * @property-read Template $template
 */
class AuditLog extends Control
{

	/** @var IAuditable */
	private $auditable;

	/** @var string */
	private $templateFile = __DIR__ . '/AuditLog.latte';

	/** @var array */
	public $statusTypes = [
		'info' => [
			'icon' => 'info',
			'color' => 'blue',
		],
		'success' => [
			'icon' => 'check-circle-o',
			'color' => 'green',
		],
		'warning' => [
			'icon' => 'exclamation-triangle',
			'color' => 'yellow',
		],
	];

	public function __construct(IAuditable $auditable)
	{
		parent::__construct();

		$this->auditable = $auditable;
	}

	public function render(): void
	{
		$this->template->statusTypes = $this->statusTypes;
		$this->template->messages = $messages = $this->auditable->getAuditMessages();
		$this->template->lastMessage = array_shift($messages);
		$this->template->setFile($this->templateFile);
		$this->template->render();
	}

	public function setTemplateFile(string $templateFile): void
	{
		if (!is_file($templateFile)) {
			throw new TemplateNotFoundException(sprintf('Template file %s was not found.', $templateFile));
		}

		$this->templateFile = $templateFile;
	}

}

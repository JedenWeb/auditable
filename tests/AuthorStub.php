<?php declare(strict_types=1);

namespace Tests\JedenWeb\AuditableModule;

use Doctrine\ORM\Mapping as ORM;
use JedenWeb\AuditableModule\Model\IAuthor;

/**
 * @ORM\Entity()
 * @author Pavel Jurásek
 */
class AuthorStub implements IAuthor
{

	/**
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $id = 1;

	public function getId(): int
	{
		return $this->id;
	}

	public function getAuditCaption(): string
	{
		return 'Author ' . $this->id;
	}

}

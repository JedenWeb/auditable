<?php declare(strict_types=1);

namespace JedenWeb\AuditableModule\Model;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 */
class AuditMessage
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @var UuidInterface
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $type;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $message;

	/**
	 * @ORM\ManyToOne(targetEntity="IAuthor", cascade={"persist"})
	 * @var IAuthor|null
	 */
	protected $createdBy;

	/**
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	protected $createdAt;

	public function __construct(string $message, string $type = 'info', IAuthor $createdBy = null)
	{
		$this->id = Uuid::uuid4();
		$this->message = $message;
		$this->type = $type;
		$this->createdBy = $createdBy;
		$this->createdAt = new \DateTime;
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getCreatedBy(): ?IAuthor
	{
		return $this->createdBy;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

}

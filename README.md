# jedenweb/auditable

## Installation

```bash
$ composer require jedenweb/auditable
```

Register Nette extension:
```neon
extensions:	
	- JedenWeb\AuditableModule\DI\AuditableExtension
``` 

Register UUID type, metadata mapping and target-entity mapping:
```neon
# example for kdyby/doctrine
doctrine:	
	types:
		uuid: Ramsey\Uuid\Doctrine\UuidType
	metadata:
		JedenWeb\AuditableModule: %appDir%/../vendor/jedenweb/auditable/src/Model
	targetEntityMappings:
		JedenWeb\AuditableModule\Model\IAuthor: My\AuthorImplementation # implement yourself
```

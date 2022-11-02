<?php


namespace Awin\Tools\CoffeeBreak\Manager;


use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

abstract class ModelManager
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @var string
     *
     * @phpstan-var class-string<T>
     */
    protected $class;

    /**
     * @param string $class
     *
     * @phpstan-param class-string<T> $class
     */
    public function __construct($class, ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->class = $class;
    }


    /**
     * @return ObjectManager
     *
     * @throws \RuntimeException
     */
    public function getObjectManager()
    {
        $manager = $this->registry->getManagerForClass($this->class);

        if (null === $manager) {
            throw new \RuntimeException(sprintf(
                'Unable to find the mapping information for the class %s.'
                .' Please check the `auto_mapping` option'
                .' (http://symfony.com/doc/current/reference/configuration/doctrine.html#configuration-overview)'
                .' or add the bundle to the `mappings` section in the doctrine configuration.',
                $this->class
            ));
        }

        return $manager;
    }

    /**
     * Returns the related Object Repository.
     *
     * @return ObjectRepository<object>
     *
     * @phpstan-return ObjectRepository<T>
     */
    protected function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->class);
    }
}

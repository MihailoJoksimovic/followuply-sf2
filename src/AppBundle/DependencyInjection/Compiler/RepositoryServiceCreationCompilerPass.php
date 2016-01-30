<?php

namespace AppBundle\DependencyInjection\Compiler;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RepositoryServiceCreationCompilerPass implements CompilerPassInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function process(ContainerBuilder $container)
    {
        $this->entityManager = $container->get('doctrine.orm.default_entity_manager');
        $meta = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $definitions = array();

        foreach ($meta as $singleEntityData) {
            if (substr($singleEntityData->getName(), 0, 9) !== 'AppBundle') {
                continue;
            }

            $serviceId = $this->getServiceId($singleEntityData);
            $definition = new Definition(
                $this->getRepositoryClass($singleEntityData),
                array($singleEntityData->getName())
            );

            $definition->setFactory(array(
                new Reference('doctrine.orm.default_entity_manager'),
                'getRepository'
            ));

            $definitions[$serviceId] = $definition;
        }

        $container->addDefinitions($definitions);
    }

    private function getRepositoryClass(ClassMetadata $singleEntityData)
    {
        $customRepositoryClass = $singleEntityData->customRepositoryClassName;

        if (!$customRepositoryClass) {
            $customRepositoryClass = $this->entityManager->getConfiguration()->getDefaultRepositoryClassName();
        }

        if (strpos($customRepositoryClass, '\\') === 0) {
            throw new \Exception(
                'Repository class shouldn\'t start with a "\". Please fix this in: ' . $singleEntityData->getName()
            );
        }

        return $customRepositoryClass;
    }

    private function getServiceId(ClassMetadata $singleEntityData)
    {
        $inflector = new Inflector();
        $class = str_replace($singleEntityData->namespace . '\\', '', $singleEntityData->name);

        return sprintf('repository.%s', $inflector->tableize($class));
    }
}

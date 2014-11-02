<?php

namespace Tmf\WordPressExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension,
    Behat\Testwork\ServiceContainer\Extension as ExtensionInterface,
    Behat\Testwork\ServiceContainer\ExtensionManager,
    Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;

use Symfony\Component\Config\FileLocator,
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\DependencyInjection\Definition;

class WordPressExtension implements ExtensionInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigKey()
    {
        return 'wordpress';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {

    }

    /**
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('path')
            ->defaultValue(__DIR__)
            ->end()
            ->end();
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadSuiteListener($container);
        $container->setParameter('wordpress.parameters', $config);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadSuiteListener(ContainerBuilder $container)
    {
        $definition = new Definition('Tmf\WordPressExtension\Listener\FeatureListener', array(
            '%wordpress.parameters%',
            '%mink.parameters%',
        ));
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, array('priority' => 0));
        $container->setDefinition('behat.wordpress.service.feature_listener', $definition);
    }
}

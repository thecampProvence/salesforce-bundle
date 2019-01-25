<?php

namespace WakeOnWeb\SalesforceBundle\DependencyInjection;

/* Imports */
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Config\Definition\Processor;
// use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
// use WakeOnWeb\SalesforceClient\REST\Gateway;
// use WakeOnWeb\SalesforceClient\REST\Client;
// use WakeOnWeb\SalesforceClient\REST\GrantType\PasswordStrategy;

class WakeonwebSalesforceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Make bundle configuration accessible to others
        $container->setParameter(
            'wakeonweb_salesforce.guzzle_client',
            $config['guzzle_client']
        );
        $container->setParameter(
            'wakeonweb_salesforce.host',
            $config['host']
        );
        $container->setParameter(
            'wakeonweb_salesforce.version',
            $config['version']
        );

        $authStrategyConfig = $config['oauth']['password_strategy'];

        $container->setParameter(
            'wakeonweb_salesforce.oauth.password_strategy.consumer_key',
            $authStrategyConfig['consumer_key']
        );
        $container->setParameter(
            'wakeonweb_salesforce.oauth.password_strategy.consumer_secret',
            $authStrategyConfig['consumer_secret']
        );
        $container->setParameter(
            'wakeonweb_salesforce.oauth.password_strategy.login',
            $authStrategyConfig['login']
        );
        $container->setParameter(
            'wakeonweb_salesforce.oauth.password_strategy.password',
            $authStrategyConfig['password']
        );
        $container->setParameter(
            'wakeonweb_salesforce.oauth.password_strategy.security_token',
            $authStrategyConfig['security_token']
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('normalizers.yml');

        $container
            ->getDefinition('wow.salesforce.client')
            ->addArgument($config['guzzle_client'] ? new Reference($config['guzzle_client']) : null)
        ;

        $container->setAlias('thecamp_salesforce.client', 'wow.salesforce.client');

        // Old process
        // $config = (new Processor())->processConfiguration(new Configuration(), $configs);

        // $serializerDefinition = $container->getDefinition('serializer');
        // $gatewayDefinition = new Definition(Gateway::class, [$config['host'], $config['version']]);
        // $authDefinition = new Definition(PasswordStrategy::class, [
        //     $authStrategyConfig['consumer_key'],
        //     $authStrategyConfig['consumer_secret'],
        //     $authStrategyConfig['login'],
        //     $authStrategyConfig['password'],
        //     $authStrategyConfig['security_token'],
        // ]);

        // $container->setDefinition('wow.salesforce.client', new Definition(
        //     Client::class, [
        //         $serializerDefinition,
        //         $gatewayDefinition,
        //         $authDefinition,
        //         $config['guzzle_client'] ? new Reference($config['guzzle_client']) : null,
        //     ]
        // ));
    }

    /**
     * {@inheritdoc}
     */
    // public function getAlias()
    // {
    //     return 'thecamp_salesforce';
    // }
}

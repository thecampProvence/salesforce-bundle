<?php

namespace Tests\WakeOnWeb\SalesforceBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WakeOnWeb\SalesforceBundle\DependencyInjection\WakeonwebSalesforceExtension;

class WakeonwebSalesforceExtensionTest extends TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $extension = new WakeonwebSalesforceExtension();

        $container->registerExtension($extension);
        $extension->load([
            'wakeonweb_salesforce' => [
                'guzzle_client' => null,
                'host'          => 'http://domain.ltd',
                'version'       => 40,
                'oauth'         => [
                    'password_strategy' => [
                        'consumer_key'    => 'toto',
                        'consumer_secret' => 'toto',
                        'login'           => 'toto',
                        'password'        => 'toto',
                        'security_token'  => 'toto',
                    ]
                ]
            ]
        ], $container);
    }
}

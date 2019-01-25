<?php

namespace Tests\WakeOnWeb\SalesforceBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WakeOnWeb\SalesforceBundle\DependencyInjection\WakeonwebSalesforceExtension;

class WakeonwebSalesforceExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;


    protected function setUp()
    {
        $this->containerBuilder = new ContainerBuilder();
        $this->containerBuilder->getCompilerPassConfig()->setOptimizationPasses([]);
        $this->containerBuilder->getCompilerPassConfig()->setRemovingPasses([]);
    }

    protected function tearDown()
    {
        $this->containerBuilder = null;
    }

    public function testLoad()
    {
        $extension = new WakeonwebSalesforceExtension();

        $this->containerBuilder->registerExtension($extension);
        $extension->load([
            'wakeonweb_salesforce' => [
                'guzzle_client' => null,
                'host'          => 'http://domain.ltd',
                'version'       => 40,
                'oauth'         => [
                    'password_strategy' => [
                        'consumer_key'    => 'sf_consumer_key',
                        'consumer_secret' => 'sf_consumer_secret',
                        'login'           => 'sf_login',
                        'password'        => 'sf_password',
                        'security_token'  => 'sf_security_token',
                    ]
                ]
            ]
        ], $this->containerBuilder);

        $this->assertTrue($this->containerBuilder->has('wow.salesforce.client'));
        $this->assertTrue($this->containerBuilder->has('wow.salesforce.gateway'));
        $this->assertTrue($this->containerBuilder->has('wow.salesforce.password_strategy'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\AccountNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\ContactNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Npe5__Affiliation__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\On_site_presence__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Program_session__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Relationship_Account_Program__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Relationship_Member_Program__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Relationship_Member_Session__cNormalizer'));
        $this->assertTrue($this->containerBuilder->has('WakeOnWeb\SalesforceClient\Normalizer\Relationship_Program_Session__cNormalizer'));

        // Aliases
        $aliasId   = 'thecamp_salesforce.client';
        $serviceId = $this->containerBuilder->getAlias($aliasId)->__toString();
        $this->assertTrue($this->containerBuilder->has($aliasId));
        $this->assertTrue($this->containerBuilder->hasAlias($aliasId));
        $this->assertEquals($serviceId, 'wow.salesforce.client');
    }
}

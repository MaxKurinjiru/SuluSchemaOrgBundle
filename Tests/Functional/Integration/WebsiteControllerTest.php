<?php

namespace Plozmun\Bundle\SuluSchemaOrgBundle\Tests\Functional\Integration;

use Sulu\Bundle\TestBundle\Testing\WebsiteTestCase;

class WebsiteControllerTest extends WebsiteTestCase
{
    public function testHomepage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testExpectedScript(): void
    {
        // Not complete script because date
        $script = '<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebSite","name":"Homepage","url":"\/"';
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $schema = $crawler->filter('.schema')->html();

        $this->assertStringContainsString($script, $schema);
    }
}

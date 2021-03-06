<?php

/*
 * This file is part of the badge-poser package.
 *
 * (c) PUGX <http://pugx.github.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PUGX\BadgeBundle\Tests\Controller;

use Packagist\Api\Client;

class GitattributesBadgeControllerTest extends PackagistWebTestCase
{
    /**
     * @group gitattributes
     */
    public function testGitattributesResponseUncommitted()
    {
        $client = static::createClient();
        static::$kernel->getContainer()->set('packagist_client', $this->packagistClient);
        $client->request('GET','/pugx/badge-poser/gitattributes');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertRegExp('/s-maxage=3600/', $client->getResponse()->headers->get('Cache-Control'));

        $svgContent = $client->getResponse()->getContent();

        $this->assertRegExp('/.gitattributes/', $svgContent);
        $this->assertRegExp('/uncommitted/', $svgContent);
    }

    /**
     * @group gitattributes
     */
    public function testGitattributesResponseCommitted()
    {
        $client = static::createClient();
        static::$kernel->getContainer()->set('packagist_client', $this->packagistClient);
        $client->request('GET','/stolt/lean-package-validator/gitattributes');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertRegExp('/s-maxage=3600/', $client->getResponse()->headers->get('Cache-Control'));

        $svgContent = $client->getResponse()->getContent();

        $this->assertRegExp('/.gitattributes/', $svgContent);
        $this->assertRegExp('/committed/', $svgContent);
    }
}

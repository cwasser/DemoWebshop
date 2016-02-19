<?php
/**
 *
 *
 * @author    Christian Wasser <christian.wasser@trivago.com>
 * @since     2016-02-18
 * @copyright 2016 (c) trivago GmbH, Duesseldorf
 * @license   All rights reserved.
 **/

namespace Cwasser\BookShopBundle\V1\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testJsonGetBookAction(){
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/books/1.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        $this->assertJson($client->getRequest()->getContent());
    }

}

<?php
/**
 * Unit test for the cart controller
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-21
 **/

namespace Cwasser\BookShopBundle\V1\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    /**
     * @dataProvider getOrderTestDataProvider
     * @param array $requestData
     */
    public function testOrderAction_ShouldReturnBadRequest(array $requestData){
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/cart',
            array($requestData),
            array(),
            array()
        );

        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function getOrderTestDataProvider(){
        return array(
            array("book_ids" => [12, 133454]),
            array("book_ids" => ['a', 12]),
            array("book_ids" => ['b', true]),
            array("book_ids" => []),
            array("book_ids" => [true, 12, 1])
        );
    }
}

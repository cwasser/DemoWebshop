<?php
/**
 * Cart controller, which is no REST controller.
 * So far this controller provide only one action for
 * ordering books by the POST request.
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-21
 **/

namespace Cwasser\BookShopBundle\Controller;


use Cwasser\BookShopBundle\V1\Service\BookManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * This method simply returns a json message for
     * a valid request with book_ids and the method is POST
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function orderAction(Request $request){
        if($request->getMethod() !== 'POST'){
            return new JsonResponse(
                "Method not allowed",
                JsonResponse::HTTP_METHOD_NOT_ALLOWED
            );
        }
        $params = $request->request->all();
        if(!is_array($params) || !isset($params['book_ids'])){
            return new JsonResponse(
                "Bad request: Required parameter \"book_ids\" is not set",
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $bookManager = $this->container->get(BookManager::DIC_NAME);
        $books = array();
        foreach($params['book_ids'] as $bookId){
            $books[] = $bookManager->get($bookId);
        }
        return new JsonResponse(
            array("message" => "Books are successfully ordered, you will receive an
            mail with the order details soon"),
            JsonResponse::HTTP_OK
        );
    }
}

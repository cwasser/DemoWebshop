<?php
/**
 * Book RESTful controller, which provides REST conform CRUD operations for the Book entity
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-17
 **/

namespace Cwasser\BookShopBundle\Controller;

use Cwasser\BookShopBundle\V1\Entity\BookInterface;
use Cwasser\BookShopBundle\V1\Service\BookManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class BookController extends FOSRestController
{
    /**
     * Get a single book instance
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Get a single Book by the given id",
     *     output="Cwasser\BookShopBundle\V1\Entity\BookInterface",
     *     statusCodes={
     *          200 = "Returned when the book is successful found",
     *          404 = "Returned when the book is not found"
     *     }
     * )
     *
     * @param Request $request
     * @param integer $id The book id
     * @return BookInterface|View|null|object
     */
    public function getBookAction(Request $request,$id){
        $book = $this->container->get(BookManager::DIC_NAME)->get($id);
        if($book){
            return $book;
        }
        return new View(null,Codes::HTTP_NOT_FOUND);
    }

    /**
     * Get all books
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Get all currently contained books",
     *     output="Cwasser\BookShopBundle\V1\Entity\BookInterface[]",
     *     statusCodes={
     *          200 = "Returned when at least one book is found",
     *          404 = "Returned when there is no book found"
     *     }
     * )
     *
     * @param Request $request
     * @return array|\Cwasser\BookShopBundle\V1\Entity\BookInterface[]|View
     */
    public function getBooksAction(Request $request){
        $books = $this->container->get(BookManager::DIC_NAME)->getAll();
        if($books){
            return $books;
        }
        return new View(null,Codes::HTTP_NOT_FOUND);
    }

    public function postBooksAction(Request $request){
        try{
            $newBook = $this->container->get(BookManager::DIC_NAME)->post(
              $request->request->all()
            );

            return $this->routeRedirectView(
                'get_book',
                $this->getRouteOptions($newBook, $request),
                Codes::HTTP_CREATED);

        } catch(InvalidArgumentException $e) {
            return new View($e->getMessage(),Codes::HTTP_BAD_REQUEST);
        }
    }

    public function putBookAction(Request $request, $id){

    }

    public function patchBookAction(Request $request, $id){

    }

    public function deleteBookAction(Request $request, $id){

    }

    private function getRouteOptions(BookInterface $book, Request $request){
        return array(
            'id' => $book->getId(),
            '_format' => $request->get('_format')
        );
    }
}

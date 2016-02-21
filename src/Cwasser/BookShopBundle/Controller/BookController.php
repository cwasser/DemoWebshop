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
     *     },
     *     views={
                "default", "v1"
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
        return new View(
            sprintf('Resource \'%s\' could not be found.', $id),
            Codes::HTTP_NOT_FOUND);
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
     *     },
     *     views={
                "default", "v1"
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
        return new View(
            'Resource could not be found',
            Codes::HTTP_NOT_FOUND);
    }

    /**
     * Create a new Book entity with the given parameters and persist it in the database.
     * It uses the Request object and validate the containing parameters with the
     * \Cwasser\BookShopBundle\V1\Form\BookType.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Created a new Book and persist it in the database",
     *     input="Cwasser\BookShopBundle\V1\Form\BookType",
     *     statusCodes={
     *          201 = "Returned when created successful",
     *          400 = "Returned on errors, e.g. when invalid data is given"
     *     },
     *     views={
                "default", "v1"
     *     }
     * )
     *
     * @param Request $request
     * @return View
     */
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

    /**
     * Update an existing book or create a new one if the book with the given
     * ID does not exists. Update or create with all the given parameters in
     * the request and persist the result in the database. Uses Cwasser\BookShopBundle\V1\Form\BookType
     * to validate the given parameter.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Update or create a book and persist the result in the database",
     *     input="Cwasser\BookShopBundle\V1\Form\BookType",
     *     statusCodes={
                201 = "Returned when a new book is created successful",
     *          204 = "Returned when the existing book is updated successful",
     *          400 = "Returned on errors, e.g. when invalid data is given"
     *     },
     *     views={
                "default", "v1"
     *     }
     * )
     *
     * @param Request $request
     * @param integer $id
     * @return View
     */
    public function putBookAction(Request $request, $id){
        try{
            $bookManager = $this->container->get(BookManager::DIC_NAME);
            $book = $bookManager->get($id);
            if($book){
                $code = Codes::HTTP_NO_CONTENT;
                $book = $bookManager->put(
                    $book,
                    $request->request->all()
                );
            }else{
                $code = Codes::HTTP_CREATED;
                $book = $bookManager->post(
                    $request->request->all()
                );
            }

            return $this->routeRedirectView(
                'get_book',
                $this->getRouteOptions($book, $request),
                $code
            );
        }catch (InvalidArgumentException $e){
            return new View($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update an existing book with the given partial parameters.
     * If the no book for the given ID exists it will return a 404. If
     * the book was found and the given parameters are valid, it will
     * update the book and persist the result in the database. It uses
     * Cwasser\BookShopBundle\V1\Form\BookType to validate the given
     * parameters.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Update an existing book with the given partial parameters",
     *     input="Cwasser\BookShopBundle\V1\Form\BookType",
     *     statusCodes={
                204 = "Returned when the update was successful",
     *          400 = "Returned on error, e.g. when invalid data is given",
     *          404 = "Returned when the resource for the given ID could not be found"
     *     },
     *     views={
                "default", "v1"
     *     }
     * )
     *
     * @param Request $request
     * @param integer $id
     * @return View
     */
    public function patchBookAction(Request $request, $id){
        try{
            $bookManager = $this->container->get(BookManager::DIC_NAME);
            $book = $bookManager->get($id);
            if($book){
                $book = $bookManager->patch(
                    $book,
                    $request->request->all()
                );

                return $this->routeRedirectView(
                    'get_book',
                    $this->getRouteOptions($book, $request),
                    Codes::HTTP_NO_CONTENT
                );
            }
            return new View(
                sprintf('Resource \'%s\' could not be found.', $id),
                Codes::HTTP_NOT_FOUND);
        }catch(InvalidArgumentException $e){
            return new View($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete an existing book with the given ID.
     * If the book with the given ID does not exists, it will return a 404. If
     * a book for the given ID was found, it will delete the book and return a
     * 204. If any other errors occur it will return a 400.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Delete the book with the given ID",
     *     input="integer $id",
     *     statusCodes={
                204 = "Returned when the resource deleted successful",
     *          400 = "Returned if any errors during the deletion occurs",
     *          404 = "Returned when the resource for the given ID could not be found"
     *     },
     *     views={
                "default", "v1"
     *     }
     * )
     *
     * @param Request $request
     * @param integer $id
     * @return View
     */
    public function deleteBookAction(Request $request, $id){
        try{
            $bookManager = $this->container->get(BookManager::DIC_NAME);
            $book = $bookManager->get($id);
            if($book){
                $bookManager->delete($book);

                return $this->routeRedirectView(
                    'get_books',
                    array('_format' => $request->get('_format')),
                    Codes::HTTP_NO_CONTENT
                );
            }
            return new View(
                sprintf('Resource \'%s\' could not be found.', $id),
                Codes::HTTP_NOT_FOUND
            );
        }catch(\Exception $e){
            return new View($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Action for the optional OPTION request. It will return
     * by standard a 405.
     *
     * @ApiDoc(
     *     resource=false,
     *     description="Action for the OPTION request, will return a 405",
     *     statusCodes={
                405 = "Returned by default, this method is not allowed"
     *     },
     *     views={
                "default","v1"
     *     }
     * )
     *
     * @return View
     */
    public function optionsBookAction(){
        return new View(
            'The method is not allowed. Allowed methods are: GET, POST, PATCH, DELETE',
            Codes::HTTP_METHOD_NOT_ALLOWED,
            array('Allow' => 'GET,POST,PUT,PATCH,DELETE')
        );
    }

    public function linkBookAction($id){
        return new View(
            'The method is not allowed. Allowed methods are: GET, POST, PATCH, DELETE',
            Codes::HTTP_METHOD_NOT_ALLOWED,
            array('Allow' => 'GET,POST,PUT,PATCH,DELETE')
        );
    }

    public function unlinkBookAction($id){
        return new View(
            'The method is not allowed. Allowed methods are: GET, POST, PATCH, DELETE',
            Codes::HTTP_METHOD_NOT_ALLOWED,
            array('Allow' => 'GET,POST,PUT,PATCH,DELETE')
        );
    }

    private function getRouteOptions(BookInterface $book, Request $request){
        return array(
            'id' => $book->getId(),
            '_format' => $request->get('_format')
        );
    }
}

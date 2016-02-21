<?php
/**
 * Book manager which use Doctrine services to provide standard CRUD
 * operations for the Book entity. This service contains all domain logic
 * for books and is used by controllers
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-18
 **/

namespace Cwasser\BookShopBundle\V1\Service;

use Cwasser\BookShopBundle\V1\Entity\BookInterface;
use Cwasser\BookShopBundle\V1\Form\BookType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormFactoryInterface;

class BookManager implements BookManagerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    const DIC_NAME = 'cwasser.book_shop_bundle.v1.service.book_manager';

    public function __construct(EntityManager $em, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
        $this->repository = $this->em->getRepository($entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id){
        return $this->repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function post(array $parameters)
    {
        $book = new $this->entityClass();

        return $this->processBookData($book,$parameters,'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function put(BookInterface $book, array $parameters)
    {
        return $this->processBookData($book, $parameters, 'PUT');
    }

    /**
     * {@inheritdoc}
     */
    public function patch(BookInterface $book, array $parameters)
    {
        return $this->processBookData($book, $parameters, 'PATCH');
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BookInterface $book){
        $bookId = $book->getId();
        try{
            $this->em->remove($book);
            $this->em->flush();
            return;
        }catch(\Exception $e){
            throw new \Exception(
                "Unable to delete the given resource with id ".$bookId,
                500,
                $e
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass()
    {
        return "$this->entityClass";
    }

    /**
     * Process given data parameters for a book
     *
     * @throws InvalidArgumentException
     * @param BookInterface $book
     * @param array $parameters
     * @param string $method
     *
     * @return BookInterface
     */
    private function processBookData(BookInterface $book, array $parameters, $method = "PUT"){
        $form = $this->formFactory->create(new BookType(), $book, array(
           'method' => $method
        ));
        $form->submit($parameters, 'PATCH' !== $method);
        if($form->isValid()) {
            $book = $form->getData();
            $this->em->persist($book);
            $this->em->flush();

            return $book;
        }

        throw new InvalidArgumentException('Invalid data given', 500, $form);
    }
}

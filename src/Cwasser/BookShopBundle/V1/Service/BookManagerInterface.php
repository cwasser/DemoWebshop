<?php
/**
 * Interface for the BookManager
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-18
 **/

namespace Cwasser\BookShopBundle\V1\Service;


use Cwasser\BookShopBundle\V1\Entity\BookInterface;

interface BookManagerInterface
{
    /**
     * Get a book by the given identifier
     *
     * @api
     * @param integer $id
     * @return BookInterface|null
     */
    public function get($id);

    /**
     * Get all books in the repository
     * @return BookInterface[]
     */
    public function getAll();

    /**
     * Post a book, which creates a new book
     *
     * @api
     * @param array $parameters
     * @return BookInterface|null
     */
    public function post(array $parameters);

    /**
     * Edit an existing book
     *
     * @param BookInterface $book
     * @param array $parameters
     * @return BookInterface|null
     */
    public function put(BookInterface $book, array $parameters);

    /**
     * Partially update an existing book
     *
     * @param BookInterface $book
     * @param array $parameters
     * @return BookInterface|null
     */
    public function patch(BookInterface $book, array $parameters);

    /**
     * Delete the given book
     *
     * @param BookInterface $book
     * @return void
     */
    public function delete(BookInterface $book);

    /**
     * Return the supported class
     *
     * @return string
     */
    public function supportsClass();

}

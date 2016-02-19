<?php
/**
 * Interface for the book entity
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-02-18
 **/

namespace Cwasser\BookShopBundle\V1\Entity;


interface BookInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set title
     *
     * @param string $title
     * @return BookInterface
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set description
     *
     * @param string $description
     * @return BookInterface
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set author
     *
     * @param string $author
     * @return BookInterface
     */
    public function setAuthor($author);

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Set publisher
     *
     * @param string $publisher
     * @return BookInterface
     */
    public function setPublisher($publisher);

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher();

    /**
     * Set isbn
     *
     * @param integer $isbn
     * @return BookInterface
     */
    public function setIsbn($isbn);

    /**
     * Get isbn
     *
     * @return integer
     */
    public function getIsbn();

    /**
     * Set language
     *
     * @param string $language
     * @return BookInterface
     */
    public function setLanguage($language);

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage();

    /**
     * Set price
     *
     * @param float $price
     * @return BookInterface
     */
    public function setPrice($price);

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice();
}

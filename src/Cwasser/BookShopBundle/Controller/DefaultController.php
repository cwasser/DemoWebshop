<?php

namespace Cwasser\BookShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CwasserBookShopBundle:Default:index.html.twig');
    }
}

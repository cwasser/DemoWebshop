<?php

namespace DemoShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $aTest = ["test" => "1", "testN" => "n"];
        return $this->render('DemoShopBundle:Default:index.html.twig',["aTest" => $aTest]);
    }
}

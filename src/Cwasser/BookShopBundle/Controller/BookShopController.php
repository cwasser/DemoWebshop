<?php
/**
 * The default index controller which only responsibility is
 * to deliver the rendered default html and all the js files to
 * the browser.
 * After this request the SPA jquery plugin steps in.
 *
 * @author    Christian Wasser <christian.wasser@chwasser.de>
 * @since     2016-04-13
 **/

namespace Cwasser\BookShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookShopController extends Controller
{
    public function indexAction(Request $request){
        return $this->render('default/index.html.twig', array());
    }
}

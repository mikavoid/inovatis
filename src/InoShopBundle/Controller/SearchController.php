<?php

namespace InoShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="shop.search")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        //Get request
        $data =$request->request->get('search');
        $search = trim(htmlspecialchars($data));

        $em = $this->getDoctrine()->getManager();
        $rep_item = $em->getRepository('AppBundle:Item');
        $items = $rep_item->findMySearch($search);
        return array(
            'items' => $items
        );
    }
}

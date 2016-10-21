<?php

namespace InoShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="shop_home")
     * @Template()
     */
    public function indexAction()
    {
        //Récupération des données
        $em = $this->getDoctrine()->getManager();
        $cats = $em->getRepository('AppBundle:Category')->findAll();
        $featured = $em->getRepository('AppBundle:Item')->findBy(
            array('featured' => 1)
        );
        $star = $em->getRepository('AppBundle:Item')->findOneBy(
            array('star' => 1)
        );

        //Envoi des données
        //return compact('cats', 'featured', 'star');
        return array(
            'cats' => $cats,
            'featured' => $featured,
            'star' => $star,
        );
        return array();
    }
}

<?php

namespace InoShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/product/{pdt_id}", name="shop.product",defaults={"pdt_id" = null})
     * @Template()
     */
    public function productAction($pdt_id = null)
    {
        if (!$pdt_id) {
            return $this->redirectToRoute('shop.products');
        }
        $em = $this->getDoctrine()->getManager();
        $rep_item= $em->getRepository('AppBundle:Item');
        $item = $rep_item->find($pdt_id);

        if (!$item) {
            return $this->redirectToRoute('shop.products');
        }
        return array(
            'item' => $item
        );
    }
    /**
     * @Route("/products", name="shop.products")
     * @Route("/products/{cat_id}", name="shop.products_from_cat",defaults={"cat_id" = null})
     * @Template()
     */
    public function productsAction($cat_id = null)
    {
        //Contiendra les valeurs à envoyer à la vue
        $ret = array();

        $em = $this->getDoctrine()->getManager();
        $rep_item= $em->getRepository('AppBundle:Item');

        //Si l'ID de la catégorie est renseignée je récupère son nom etles produits associés
        if ($cat_id) {
            $rep_cat= $em->getRepository('AppBundle:Category');
            $cat= $rep_cat->findOneBy(
                array('id' => $cat_id)
            );
            if (!$cat) {
                return $this->redirectToRoute('shop.products');
            }
            $featured = $rep_item->findBy(
                array('category' => $cat_id)
            );
        } else {
            //Sinon je récupère tous les produits de toutes les catégories
            $featured = $rep_item->findAll();
        }

        return  array(
            'featured' => $featured,
            'cat' => (isset($cat) ? $cat->getName() : null)
        );
    }
}

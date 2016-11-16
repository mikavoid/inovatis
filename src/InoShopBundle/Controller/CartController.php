<?php

namespace InoShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * @Route(  "/cart",
     *          name="shop.cart")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('cart')) {
            $session->set('cart', array());
        }
        $cart = $session->get('cart');
        $cart_data = array();

        foreach ($cart as $pdt_id => $pdt_qty) {
            $rep = $this->getDoctrine()->getRepository('AppBundle:Item');
            $product = $rep->find($pdt_id);
            if ($product) {
                $cart_data[] = array(
                    'product_name' => $product->getName(),
                    'product_id' => $product->getId(),
                    'product_unit_price' => '$ ' . number_format($product->getPrice(), 2, '.', ' '),
                    'product_total_price' => '$ ' . number_format($product->getPrice() * $pdt_qty, 2, '.', ' '),
                    'product_total_price_raw' => $product->getPrice() * $pdt_qty,
                    'quantity' => $pdt_qty
                );
            }
        }
        return array('cart' => $cart_data);
    }

    /**
     * @Route(  "/cart/order",
     *          name="shop.order")
     * @Template()
     */
    public function orderAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('cart')) {
            $session->set('cart', array());
        }
        $cart = $session->get('cart');

        return array('cart' => '');
    }

    /**
     * @Route("/shop/addToCart/{pdt_id}",
     *          defaults={"pdt_id" = null},
     *          name="shop.addToCart")
     */
    public function addToCartAction(Request $request, $pdt_id)
    {
        $qty = 1;
        if ($request->get('pdt_qty')) {
            $qty = $request->get('pdt_qty');
        }
        $cart_item = array(
            'pdt_id' => intval($pdt_id),
            'pdt_qty' => intval($qty)
        );

        $session = $request->getSession();

        //Si la session n'a pas de panier on l'ajoute
        if (!$session->has('cart')) {
            $session->set('cart', array());
        }
        //On récupère le panier
        $cart = $session->get('cart');

        if (array_key_exists($cart_item['pdt_id'], $cart)) {
            $cart[$cart_item['pdt_id']] += $cart_item['pdt_qty'];
        } else {
            $cart[$cart_item['pdt_id']] = $cart_item['pdt_qty'];
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('shop.cart');
    }

    /**
     * @Route("/shop/removeFromCart/{pdt_id}",
     *          defaults={"pdt_id" = null},
     *          name="shop.removeFromCart")
     */
    public function removeFromCartAction(Request $request, $pdt_id)
    {
        $session = $request->getSession();
        if (!$session->has('cart')) {
            $session->set('cart', array());
        }
        $cart = $session->get('cart');
        if (array_key_exists($pdt_id, $cart)) {
            unset($cart[$pdt_id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('shop.cart');
    }
}

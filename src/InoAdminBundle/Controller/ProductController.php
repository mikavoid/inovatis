<?php

namespace InoAdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;

use AppBundle\Entity\Item;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    /**
     * @Route("/products", name="admin.products")
     * @Template()
     */
    public function productsAction()
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Item')->findAll();
        return array('products' => $products);
    }
    /**
     * @Route("/delete-product/{id}", name="admin.deleteProduct", defaults={"id" : "0"})
     */
    public function deleteProduct($id) {
        if($id) {

            $rep = $this->getDoctrine()->getRepository('AppBundle:Item');
            $product = $rep->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            $this->addFlash('notice', 'A product has been successfully removed !');
        }
        return $this->redirectToRoute('admin.products');
    }


    /**
     * @Route("/edit-product/{id}", name="admin.editProduct", defaults={"id" : "0"})
     * @Template()
     */
    public function editProductAction(Request $request, $id)
    {
        $product = new Item();
        $action = 'add';
        if ($id) {
            $product = $this->getDoctrine()->getRepository('AppBundle:Item')->find($id);
            $old_image = $product->getImage();
            if (!$product) {
                $this->addFlash('error', 'Product is missing');
                return $this->redirectToRoute('admin.products');
            }
            $action = 'edit';
        }
        $form = $this->createForm(ProductType::class, $product, array());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $product->getImage();
            if (isset($file) && !empty($file)) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('photos_directory'),
                    $fileName
                );
                $product->setImage($fileName);
            }
            $product = $form->getData();
            if (empty($product->getImage())) {
                $product->setImage($old_image);
            }
            //Save to db
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('notice', 'A product has been successfully '. $action .'ed !');
            return $this->redirectToRoute('admin.products');

        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/ajax_set_bool",
     *      name="admin.ajaxSetBool",
     *      options = { "expose" = true }
     * )
     */
    public function ajaxSetBool(Request $request) {
        if ($request->isXMLHttpRequest()) {
            //Déclaration et initialisation des variables
            $bool_name = strtolower(htmlspecialchars($request->get('bool_name')));
            $product_id = intval(htmlspecialchars($request->get('product_id')));
            $checked = ($request->get('checked') === 'true' ? true : false);

            //Update du produit
            if (!empty($product_id)) {
                $product = $this->getDoctrine()->getRepository('AppBundle:Item')->find($product_id);
                if ($product) {
                    $setter_name = 'set' . ucfirst($bool_name);
                    $product->{$setter_name}($checked);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $res_str = 'done';
            }
        }

        $res = array('data' => array(
            'value' => $res_str
        ));
        return new Response(json_encode($res));
    }

    /**
     * @Route("/ajax_search",
     *      name="admin.ajaxSearch",
     *      options = { "expose" = true }
     * )
     */
    public function ajaxSearch(Request $request)
    {
        $search_terms= strtolower(htmlspecialchars($request->get('search_terms')));
        //on sous entends qu'on cherche des produits
        if ($request->isXMLHttpRequest()) {
            $products = $this->getDoctrine()->getRepository('AppBundle:Item')->findMySearch($search_terms);
            return $this->render('@InoAdmin/Product/Ajax/products_search_results.html.twig', array('products' => $products));
        }
        return new Response();
    }
}

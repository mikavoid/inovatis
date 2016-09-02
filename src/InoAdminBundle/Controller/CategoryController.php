<?php

namespace InoAdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Category;


class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="admin.categories")
     * @Template()
     */
    public function categoriesAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return array('categories' => $categories);
    }

    /**
     * @Route("/delete-category/{id}", name="admin.deleteCategory", defaults={"id" : "0"})
     */
    public function deleteCategory($id) {
        if($id) {

            $rep = $this->getDoctrine()->getRepository('AppBundle:Category');
            $cat = $rep->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($cat);
            $em->flush();
            $this->addFlash('notice', 'A category has been successfully removed !');
        }
        return $this->redirectToRoute('admin.categories');
    }
    /**
     * @Route("/edit-category/{id}", name="admin.editCategory", defaults={"id" : "0"})
     * @Template()
     */
    public function editCategoryAction(Request $request, $id)
    {
        $cat = new Category();
        $action = 'add';
        if ($id) {
            $cat = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
            if (!$cat) {
                $this->addFlash('error', 'Category is missing');
                return $this->redirectToRoute('admin.categories');
            }
            $action = 'edit';
        }



        $form = $this->createFormBuilder($cat)
            ->add('name', TextType::class)
            ->add('Save', SubmitType::class)
            ->setMethod('POST')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();

            //Save to db
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            $this->addFlash('notice', 'A category has been seccessfully ' . $action . 'ed !');
            return $this->redirectToRoute('admin.categories');

        }

        return array('form' => $form->createView());
    }

}

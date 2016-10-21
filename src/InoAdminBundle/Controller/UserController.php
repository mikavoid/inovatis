<?php

namespace InoAdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;


class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/users/{customer}", name="admin.users", defaults = {"customer" : "cus"})
     * @Template()
     */
    public function usersAction($customer)
    {
        $role = '';
        if ($customer === 'admin') {
            $role = 'ROLE_ADMIN';
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User')
        ;

        $users = $repository->myFindByRoles($role);
        //$users = $repository->findAll();
        //$users = $this->getDoctrine()->getRepository('AppBundle:User')->myFin;

        return array('users' => $users);
    }

    /**
     * @Route("/delete-user/{id}", name="admin.deleteUser", defaults={"id" : "0"})
     */
    public function deleteUser($id) {
        if($id) {

            $rep = $this->getDoctrine()->getRepository('AppBundle:User');
            $usr = $rep->find($id);

            $em = $this->getDoctrine()->getManager();
            $em->remove($usr);
            $em->flush();
            $this->addFlash('notice', 'The user has been successfully removed !');
        }
        return $this->redirectToRoute('admin.users');
    }
    /**
     * @Route("/edit-user/{id}", name="admin.editUser", defaults={"id" : "0"})
     * @Template()
     */
    public function editUserAction(Request $request, $id)
    {
        $usr = new User();
        $action = 'add';
        if ($id) {
            $usr = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
            if (!$usr) {
                $this->addFlash('error', 'User is missing');
                return $this->redirectToRoute('admin.users');
            }
            $action = 'edit';
        }



       /* $form = $this->createFormBuilder($usr)
            ->add('username', TextType::class)
            ->add('Save', SubmitType::class)
            ->setMethod('POST')
            ->getForm();*/

        $form = $this->createForm(RegistrationType::class, $usr, array());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usr = $form->getData();

            //Save to db
            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();

            $this->addFlash('notice', 'The user has been seccessfully ' . $action . 'ed !');
            return $this->redirectToRoute('admin.users');

        }

        return array('form' => $form->createView());
    }
}

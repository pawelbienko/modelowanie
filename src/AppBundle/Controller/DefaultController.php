<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/users", name="users")
     */
    public function usersAction() {
        //access user manager services 

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        
        return $this->render('default/users.html.twig', array('users' => $users));
    }

    /**
     * @Route("/admin/users/remove/{id}", name="users_remove")
     */
    public function removeUserAction($id) {
        //access user manager services 

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
        $userManager->deleteUser($user);

        return $this->redirectToRoute('users');

    }

    /**
     * @Route("admin/users/edit/{id}", name="users_edit")
     */
    public function editUserAction($id, Request $request) {
        //access user manager services 
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('verifed', ChoiceType::class, [
                'choices'  => [
                    'tak' => true,
                    'nie' => false,
                ]
            ])
            ->add('enabled', ChoiceType::class, [
                'choices'  => [
                    'tak' => true,
                    'nie' => false,
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices'  => [
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_USER' => 'ROLE_USER'
                ]
            ])
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $userManager->updateUser($user);

            return $this->redirectToRoute('users');
        }

        return $this->render('default/admin_edit_user.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

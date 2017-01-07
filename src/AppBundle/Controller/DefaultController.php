<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Book;

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

    /**
     * @Route("/books", name="books")
     */
    public function booksAction() {
        $books = $this->getDoctrine()
        ->getRepository('AppBundle:Book')
        ->findAll();

        return $this->render('default/books.html.twig', array('books' => $books));
    }

    /**
     * @Route("/admin/books/add", name="books_add")
     */
    public function addBooksAction(Request $request) {
        $book = new Book();

        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute('books');
        }

        return $this->render('default/add_book.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/books/edit/{id}", name="books_edit")
     */
    public function editBooksAction($id, Request $request) {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Book')
            ->find($id); 

        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute('books');
        }

        return $this->render('default/add_book.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/books/remove/{id}", name="books_remove")
     */
    public function removeBooksAction($id) {
        //access user manager services 

        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Book')
            ->find($id); 

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('books');

    }
}

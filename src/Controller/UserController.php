<?php

namespace App\Controller;

use App\Entity\Lecture;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/users")
 */
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/management", name="user.index", methods="GET|POST")
     * @return Response
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/create", name="user.add", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'User has been created.');
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user.edit", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'User has been updated.');
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="user.delete", methods="DELETE")
     * @param Lecture $lecture
     * @param Request $request
     * @return Response
     */
    public function delete(Lecture $lecture, Request $request)
    {
        if ($this->isCsrfTokenValid('delete-' . $lecture->getId(), $request->get('_token'))) {
            $this->entityManager->remove($lecture);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lecture has been deleted.');
        }

        return $this->redirectToRoute('lecture.index');
    }
}
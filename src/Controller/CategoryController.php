<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private CategoryRepository $categoryRepository;

    /**
     * CategoryController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/category-management", name="category.index", methods="GET")
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->categoryRepository->findBy([], ['name' => 'ASC']);
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/create", name="category.add", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Category has been created.');
            return $this->redirectToRoute('category.index');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{name}", name="category.edit", methods="GET|POST")
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Category has been updated.');
            return $this->redirectToRoute('category.index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="category.delete", methods="DELETE")
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Category $category, Request $request): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete-' . $category->getId(), $request->get('_token'))) {
            if (empty($category->getLectures()->getValues())) {
                $this->entityManager->remove($category);
                $this->entityManager->flush();
                $this->addFlash('success', 'Category has been deleted.');
            }
        }

        return $this->redirectToRoute('category.index');
    }
}
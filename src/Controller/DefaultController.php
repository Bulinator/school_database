<?php


namespace App\Controller;

use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\LectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private LectureRepository $lectureRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        LectureRepository $lectureRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->lectureRepository = $lectureRepository;
    }

    /**
     * @Route("/", name="default.dashboard", methods="GET|POST")
     * @return Response
     */
    public function dashboard(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $lectures = $this->lectureRepository->findAll();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $results = $this->lectureRepository->findOneBy(['id' => $data['lecture']->getId()]);
            $form = $this->createForm(SearchType::class);
        }
        return $this->render('default/index.html.twig', [
            'categories' => $categories,
            'lectures' => $lectures,
            'form' => $form->createView(),
            'results' => $results ?? null
        ]);
    }
}
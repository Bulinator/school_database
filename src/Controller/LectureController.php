<?php

namespace App\Controller;

use App\Entity\Lecture;
use App\Form\LectureType;
use App\Repository\LectureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class LectureController
 * @package App\Controller
 * @Route("/lecture")
 */
class LectureController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private LectureRepository $lectureRepository;
    private SluggerInterface $slugger;

    /**
     * LectureController constructor.
     * @param EntityManagerInterface $entityManager
     * @param LectureRepository $lectureRepository
     * @param SluggerInterface $slugger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        LectureRepository $lectureRepository,
        SluggerInterface $slugger
    )
    {
        $this->entityManager = $entityManager;

        $this->lectureRepository = $lectureRepository;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/management", name="lecture.index", methods="GET|POST")
     * @return Response
     */
    public function index(): Response
    {
        $lectures = $this->lectureRepository->findAll();
        return $this->render('lecture/index.html.twig', [
            'lectures' => $lectures
        ]);
    }

    /**
     * @Route("/create", name="lecture.add", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $lecture = new Lecture();
        $form = $this->createForm(LectureType::class, $lecture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $slug = $this->_slugger($data);
            $index = $this->_setLectureIndex($data);
            $lecture->setSlug($slug);
            $lecture->setLectureIndex($index);
            $this->entityManager->persist($lecture);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lecture has been created.');
            return $this->redirectToRoute('lecture.index');
        }
        return $this->render('lecture/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{slug}", name="lecture.edit", methods="GET|POST")
     * @param Lecture $lecture
     * @param Request $request
     * @return Response
     */
    public function edit(Lecture $lecture, Request $request)
    {
        $form = $this->createForm(LectureType::class, $lecture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $slug = $this->_slugger($data);
            $index = $this->_setLectureIndex($data);
            $lecture->setSlug($slug);
            $lecture->setLectureIndex($index);
            $this->entityManager->persist($lecture);
            $this->entityManager->flush();
            $this->addFlash('success', 'Lecture has been updated.');
            return $this->redirectToRoute('lecture.index');
        }
        return $this->render('lecture/edit.html.twig', [
            'lecture' => $lecture,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="lecture.delete", methods="DELETE")
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

    /**
     * @param Lecture $lecture
     * @return string
     */
    private function _slugger(Lecture $lecture): string
    {
        return $this->slugger->slug($lecture->getName());
    }

    /**
     * @param Lecture $lecture
     * @return string
     */
    private function _setLectureIndex(Lecture $lecture): string
    {
        $index = 1;
        $lastIndex = $this->lectureRepository->findOneBy([], ['createdAt' => 'DESC']);
        if ($lastIndex) {
            $index++;
        }

        return date('Y') . '-' . date('m') . '-' . sprintf("%02d", $index);;
    }
}
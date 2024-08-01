<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Repository\AssociationRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class SearchController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'app_search')]
    public function index(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(SearchStudentType::class, $student);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $student->getLastName();

            return $this->redirectToRoute('app_search_results', ['search' => $search]);
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'search_form' => $form,
        ]);
    }

    #[Route('/resultats/{search}', name: 'app_search_results')]
    public function searchResults(StudentRepository $studentRepository, string $search): Response
    {
        $students = $studentRepository->findByName($search);
        //$students = $studentRepository->findAll();

        return $this->render('search/results.html.twig', [
            'search' => $search,
            'students' => $students,
        ]);
    }

    #[Route('/etudiant/{slug}', name: 'app_student')]
    public function show(Environment $twig, Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student
        ]);
    }
}

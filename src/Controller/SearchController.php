<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\AssociationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    #[Route('/etudiant/{slug}', name: 'student')]
    public function show(Environment $twig, Student $student): Response
    {
        return new Response($twig->render('student/show.html.twig', [
            'student' => $student
        ]));
    }
}

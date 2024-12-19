<?php
namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('app_cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/new.html.twig', [
            'cours' => $cours,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'cours_show', methods: ['GET'])]
    public function show(Cours $cours): Response
    {
        return $this->render('cours/show.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/{id}/edit', name: 'cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/edit.html.twig', [
            'cours' => $cours,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cours->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cours);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index');
    }
}

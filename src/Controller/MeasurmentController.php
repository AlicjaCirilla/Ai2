<?php

namespace App\Controller;

use App\Entity\Measurment;
use App\Form\MeasurmentType;
use App\Repository\MeasurmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/measurment')]
final class MeasurmentController extends AbstractController
{
    #[Route(name: 'app_measurment_index', methods: ['GET'])]
    public function index(MeasurmentRepository $measurmentRepository): Response
    {
        return $this->render('measurment/index.html.twig', [
            'measurments' => $measurmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $measurment = new Measurment();
        $form = $this->createForm(MeasurmentType::class, $measurment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($measurment);
            $entityManager->flush();

            return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurment/new.html.twig', [
            'measurment' => $measurment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurment_show', methods: ['GET'])]
    public function show(Measurment $measurment): Response
    {
        return $this->render('measurment/show.html.twig', [
            'measurment' => $measurment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measurment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Measurment $measurment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeasurmentType::class, $measurment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurment/edit.html.twig', [
            'measurment' => $measurment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurment_delete', methods: ['POST'])]
    public function delete(Request $request, Measurment $measurment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($measurment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
    }
}

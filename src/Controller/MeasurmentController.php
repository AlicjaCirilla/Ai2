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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/measurment')]
final class MeasurmentController extends AbstractController
{
    #[Route(name: 'app_measurment_index', methods: ['GET'])]
    #[IsGranted('ROLE_MEASURMENT_INDEX')]
    public function index(MeasurmentRepository $measurmentRepository): Response
    {
        return $this->render('measurment/index.html.twig', [
            'measurments' => $measurmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurment_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASURMENT_NEW')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $measurment = new Measurment();
        $form = $this->createForm(MeasurmentType::class, $measurment, [
            'validation_groups'=> 'create',
        ]);

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
    #[IsGranted('ROLE_MEASURMENT_SHOW')]
    public function show(Measurment $measurment): Response
    {
        return $this->render('measurment/show.html.twig', [
            'measurment' => $measurment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measurment_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASURMENT_EDIT')]
    public function edit(Request $request, Measurment $measurment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeasurmentType::class, $measurment, [
        'validation_groups'=> 'edit',
        ]);
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
    #[IsGranted('ROLE_MEASURMENT_DELETE')]
    public function delete(Request $request, Measurment $measurment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($measurment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
    }
}

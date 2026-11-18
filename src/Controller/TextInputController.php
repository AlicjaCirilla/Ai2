<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\TextInputType;

final class TextInputController extends AbstractController
{
    #[Route('/text/input', name: 'app_text_input')]
    public function index(Request $request,): Response
    {

        $form= $this-> createForm(TextInputType::class);
        $form->handleRequest($request);
        $textInput=null;
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $textInput= $data['text'];

        }
        return $this->render('text_input/index.html.twig', [
            'form' => $form->CreateView(),
            'textInput' => $textInput,
        ]);
    }
}

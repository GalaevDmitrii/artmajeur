<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Demand;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demand = new Demand();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        $success = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $demand->setDate(new \DateTime());
            $demand->setDemand([
                'name' => $form->get('name')->getData(),
                'email' => $form->get('email')->getData(),
                'question' => $form->get('question')->getData(),
            ]);
            $demand->setStatus("New");

            $entityManager->persist($demand);
            $entityManager->flush();

            $successMessage = 'Your message was sent successfully.';

            $success = true;
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'success' => $success,
            'successMessage' => $successMessage ?? null
        ]);
    }
}

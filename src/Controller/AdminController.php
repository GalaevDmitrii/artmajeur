<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    #[Route('/dashboard', name: 'dashboard')]
    public function index(DemandRepository $demandRepository): Response
    {
        $demands = $demandRepository->findAll();

        $groupedDemands = [];
        foreach ($demands as $demand) {
            $demandArray = $demand->getDemand();
            $email = isset($demandArray[1]) ? $demandArray[1] : '';

            if (!array_key_exists($email, $groupedDemands)) {
                $groupedDemands[$email] = [];
            }

            $groupedDemands[$email][] = $demand;
        }



        return $this->render('admin/dashboard.html.twig', [
            'groupedDemands' => $groupedDemands,
        ]);
    }


    #[Route('/demand/update-status/{id}', name: 'update_demand_status')]
    public function updateDemandStatus($id, DemandRepository $demandRepository, EntityManagerInterface $entityManager)
    {
        $demand = $demandRepository->find($id);

        if (!$demand) {
            throw $this->createNotFoundException('Demand not found');
        }

        $demand->setStatus('answered');

        $entityManager->persist($demand);
        $entityManager->flush();

        return $this->redirectToRoute('dashboard');
    }
}

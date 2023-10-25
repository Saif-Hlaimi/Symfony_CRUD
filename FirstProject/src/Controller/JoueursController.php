<?php

namespace App\Controller;

use App\Entity\Joueurs;
use App\Form\AddplayerType;
use App\Repository\JoueursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoueursController extends AbstractController
{
    #[Route('/joueurs', name: 'app_joueurs')]
    public function index(): Response
    {
        return $this->render('joueurs/index.html.twig', [
            'controller_name' => 'JoueursController',
        ]);
    }

    #[Route("/showplayer",name : "showplayer")]
    public function show(JoueursRepository $joueur){
        $j = $joueur->findAll();
        return $this->render('joueurs/afficher.html.twig',['joueur' => $j]);
    }

    #[Route("/suppplayer",name : "suppplayer")]
    public function effacer(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Joueurs::class);

        
        $goal = $repository->findBy(['role' => 'gardien']);

        foreach ($goal as $goalkeeper) {
            $entityManager->remove($goalkeeper);
        }

        
        $entityManager->flush();

        return new Response('Les gardiens ont été supprimés.');
    }
}
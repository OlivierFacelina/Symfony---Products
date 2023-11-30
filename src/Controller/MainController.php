<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Tax\Calculator;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

# Ceci évitera à chaque fois de mettre app dans le nom d'une route qu'on aura créé
#[Route(name: 'app_')]

# On crée la classe MainController qui étendra pour pouvoir se rendre dans les templates
class MainController extends AbstractController{

    # On crée une page 
    #[Route('/', name: 'main')]
    public function index (WalletRepository $walletRepository, EntityManagerInterface $entityManagerInterface) {

        $wallet = $walletRepository->find(1);
        $wallet->addCredits(1500);

        $entityManagerInterface->flush();

        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('main.html.twig');
    }

    #[Route('/layout', name: 'layout')]
    public function tutoLayout () {
        return $this->render('tuto-twig/home.html.twig');
    }

    #[Route('/layout-disc', name: 'discover')]
    public function discover () {
        return $this->render('tuto-twig/discover.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact () {
       
        $html = $this->render('contact.html.twig', [
            'etudiant1' => [
                'prenom' => 'Matthieu',
                'nom' => 'Maghalaes',
            ],
            'etudiant2' => [
                'prenom' => 'Olivier',
                'nom' => 'Facelina',
            ],
        ]);
        return new Response($html);
        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        // return $this->render('contact.html.twig');
    }
}
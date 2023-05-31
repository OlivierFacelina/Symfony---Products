<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Tax\Calculator;
use Cocur\Slugify\Slugify;

# Ceci évitera à chaque fois de mettre app dans le nom d'une route qu'on aura créé
#[Route(name: 'app_')]

# On crée la classe MainController qui étendra pour pouvoir se rendre dans les templates
class MainController extends AbstractController{

    # On crée une page 
    #[Route('/', name: 'main')]
    public function test (Request $request, Calculator $calculator, Slugify $slugify) {

        $slugify = new Slugify();
        dd($slugify->slugify('Bonjour à tous !'));
        dd($calculator->calculTTC(120));
        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('main.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact () {
       
        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('contact.html.twig');
    }
}
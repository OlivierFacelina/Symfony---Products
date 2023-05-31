<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;


# Ceci évitera à chaque fois de mettre app dans le nom d'une route qu'on aura créé
#[Route(name: 'app_')]

# On crée la classe MainController qui étendra pour pouvoir se rendre dans les templates
class ProductController extends AbstractController{

    # On crée une page 
    #[Route('/product', name: 'product')]
    public function index (EntityManagerInterface $entityManager) {

        # Ca va récupérer tous les produits existants
        $products = $entityManager->getRepository(Product::class)->findBy(['valid' => true]);
       
        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('product/index.html.twig', [
            "products" => $products
        ]);
    }

    #[Route('/product/new', name: 'product_new')]
    public function new (Request $request, EntityManagerInterface $manager) {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setValid(true);

            # Lorsque notre produit est prêt, on le prépare
            $manager->persist($product);
            
            # On l'envoie
            $manager->flush();

            $this->addFlash('success', 'Félicitations vous avez créé le produit : ' . $product->getName());

            return $this->redirectToRoute('app_product');
        }

        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('product/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show ($id, EntityManagerInterface $entityManager) {

        $product = $entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

        if(is_null($product)) {
            return $this->redirectToRoute('app_product');
        }
        # On se rend dans le dossier template en utilisant this, puisqu'on l'a étendu
        return $this->render('product/show.html.twig', [
            "product" => $product
        ]);
    }
}
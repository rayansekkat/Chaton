<?php

namespace App\Controller;
use App\Entity\Chaton;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        //$name = getName();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Chaton::class);
        $chaton = $repository->findAll();

        //$finder = new Finder();

        //$finder->directories()->in('../public/photos');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
           
            'chaton' => $chaton,
            //"dossiers" => $finder,
        ]);
    }



}

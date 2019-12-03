<?php

namespace App\Controller;
use App\Entity\Chaton;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        //$name = getName();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->findAll();

        //$finder = new Finder();

        //$finder->directories()->in('../public/photos');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
           
            'client' => $client,
            //"dossiers" => $finder,
        ]);
    }



}

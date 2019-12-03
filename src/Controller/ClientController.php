<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->findAll();
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'client' => $client,
        ]);
    }

    /**
     * @Route("/create-client", name="create-client")
     */
    public function createClient(Request $request)  
    {
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        if($request->isMethod('POST')&& $form->handleRequest($request)->isValid()){
            $em->persist($client);
            $em->flush();

            return new RedirectResponse('/client');
        }

        return $this->render('home/createClient.html.twig', [
            'form' => $form->createView(),
        ]);
    }

                /**
     * @Route("/delate/{id}", name="delate_client")
     * 
     * @return Response
     */

    public function delateClient(Client $client)
    {
        if (!$client) {
            throw $this->createNotFoundException('No client found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        //return new Response('Chaton supprimé');
        return new RedirectResponse('/client');
    }

 /**
     * @Route("/categories/modifier/{id}", name="edit_client")
     */
    public function modifier($id, Request $request)
    {
        $repository=$this->getDoctrine()->getRepository(Client::class);
        $client=$repository->find($id);

        //creation du formmulaire
        $formulaire=$this->createForm(ClientType::class, $client);

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD comme new PDO)
            $em=$this->getDoctrine()->getManager();

            //Je dis au manager que je veux ajouter la categorie dans la BDD
            $em->persist($client);

            $em->flush();

            return $this->redirectToRoute("client");
        }

        return $this->render('client/editClient.html.twig', [
            "formulaire"=>$formulaire->createView(),
         //   "h1"=>"Modification de la catégorie <i>".$client->GetTitre()."</i>",
        ]);
    }
    /**
     * @Route("/edit", name="edit")
     */
    public function edit()
    {
    
        return $this->render('client/editClient.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}

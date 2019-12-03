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
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
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

            return new RedirectResponse('/home');
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
        return new RedirectResponse('/home');
    }

}

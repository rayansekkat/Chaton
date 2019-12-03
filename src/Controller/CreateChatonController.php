<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Chaton;
use App\Form\ChatonType;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class CreateChatonController extends Controller
{
    /**
     * @Route("/create-chaton", name="create-chaton")
     */
    public function createChaton(Request $request)  
    {
        $em = $this->getDoctrine()->getManager();
        $chaton = new Chaton();
        $form = $this->createForm(ChatonType::class, $chaton);

        if($request->isMethod('POST')&& $form->handleRequest($request)->isValid()){
            $em->persist($chaton);
            $em->flush();

            return new RedirectResponse('/home');
        }

        return $this->render('home/createChaton.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delate/{id}", name="delate_chaton")
     * 
     * @return Response
     */

    public function delate(Chaton $chaton)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($chaton);
        $entityManager->flush();

        //return new Response('Chaton supprimé');
        return new RedirectResponse('/home');
    }

     /**
     * @Route("/chaton/modifier/{id}", name="edit_chaton")
     */
    public function modifier($id, Request $request)
    {
        $repository=$this->getDoctrine()->getRepository(Chaton::class);
        $chaton=$repository->find($id);

        //creation du formmulaire
        $formulaire=$this->createForm(ChatonType::class, $chaton);

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid())
        {
            //récupérer l'entity manager (sorte de connexion à la BDD comme new PDO)
            $em=$this->getDoctrine()->getManager();

            //Je dis au manager que je veux ajouter la categorie dans la BDD
            $em->persist($chaton);

            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('home/editChaton.html.twig', [
            "formulaire"=>$formulaire->createView(),
         //   "h1"=>"Modification de la catégorie <i>".$client->GetTitre()."</i>",
        ]);
    }
}

  




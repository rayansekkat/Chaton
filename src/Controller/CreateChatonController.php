<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Chaton;
use App\Form\ChatonType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\AbstractType;


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
        if (!$chaton) {
            throw $this->createNotFoundException('No chaton found');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($chaton);
        $em->flush();

        //return new Response('Chaton supprimé');
        return new RedirectResponse('/home');
    }

        /**
     * @Route("/photo/{nomDuDossier}", name="afficherDossier")
     */
   /* public function afficherDossier($nomDuDossier, Request $request)
    {
        
        $finder = new Finder();
        $finder->files()->in("../public/photos/$nomDuDossier");

        //creation formulaire
        $form = $this->createFormBuilder()
        ->add("photo", FileType::class, ["label"=>"Ajouter un chaton"])
        ->add("ajouter", SubmitType::class,["label"=>"Ok","attr"=>["class"=>"btn btn-sucess"]])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $data["photo"]->move("../public/photos/$nomDuDossier", $data["photo"]->getClientOriginalName());
        }

        return $this->render("home/createChaton.html.twig",[
            "fichiers"=>$finder,
            "nomDuDossier"=>$nomDuDossier,
            "formulaire"=>$form->createView(),
        ]);
    }*/
}



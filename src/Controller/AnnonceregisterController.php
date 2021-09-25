<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesLogement;
use App\Form\AnnoncesEquipements;
use App\Form\AnnoncesColocataires;
use App\Form\AnnoncesActivites;
use App\Form\AnnoncesPhotos;
use App\Form\AnnoncesValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annoncesregister")
 */
class AnnonceregisterController extends AbstractController
{
    /**
     * @Route("/logement", name="annonceregisterlogement", methods={"GET","POST"})
     */
    public function logement(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesLogement::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
            
        }

        return $this->render('annonceregister/logement.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/equipements", name="annonceregisterequipement", methods={"GET","POST"})
     */
    public function equipements(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesEquipements::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
            
        }

        return $this->render('annonceregister/equipements.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/colocataires", name="annonceregistercolocataire", methods={"GET","POST"})
     */
    public function colocataires(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesColocataires::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
            
        }

        return $this->render('annonceregister/colocataires.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/activites", name="annonceregisteractivites", methods={"GET","POST"})
     */
    public function activites(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesActivites::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
            
        }

        return $this->render('annonceregister/activites.html.twig', [
            'form' => $form->createView()
        ]);
    }
        /**
     * @Route("/photos", name="annonceregisterphotos", methods={"GET","POST"})
     */
    public function photos(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesPhotos::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $file1 = $form->get('img1')->getData();
            $fileName = md5(uniqid()).'.'.$file1->guessExtension();
            $file1->move($this->getParameter('upload_directory'),$fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setImg1($fileName);

            $file = $form->get('img2')->getData();
            if(isset($file))
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg2($fileName);
            }


            $file = $form->get('img3')->getData();
            if(isset($file))
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg3($fileName);
            }

            $file = $form->get('img4')->getData();
            if(isset($file))
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg4($fileName);
            }
        }
        return $this->render('annonceregister/photos.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/validation", name="annonceregistervalidation", methods={"GET","POST"})
     */
    public function validation(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesValidation::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }
        return $this->render('annonceregister/validation.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }
}
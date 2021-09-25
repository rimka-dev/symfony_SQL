<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\User;
use App\Form\AnnoncesType;
use App\Form\AnnoncesSearchType;
use App\Repository\AnnoncesRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


/**
 * @Route("/annonces")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="annonces_index", methods={"GET"})
     */
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        return $this->render('annonces/index.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="annonces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setDateCreation(new DateTime());

            $file1 = $form->get('img1')->getData();
            $fileName = md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move($this->getParameter('upload_directory'), $fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setImg1($fileName);

            $file = $form->get('img2')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg2($fileName);
            }
            $file = $form->get('img3')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg3($fileName);
            }

            $file = $form->get('img4')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg4($fileName);
            }


            // pour faire des tests sur les annonces on creer le user en dur
            //TODO modifier pour recuperer le this->getUser;
          
            $annonce->setUser($this->getUser());
            
            $entityManager->persist($annonce);
            $entityManager->flush(); 

            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('annonces/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }
//======================= recherche avec React =====================================
    /**
     * @Route("/api/search/{query}", methods={"GET"})
     */
    public function search($query, AnnoncesRepository $annonceRepository, LoggerInterface $logger)
    {
        //$this->denyAccessUnlessGranted("ROLE_USER");

        // $listAuteur = $auteurRepository->findBy(array(), array('nom' => 'DESC'));
        // $listAuteur = $auteurRepository->findAllArray();

        // $listAuteur = $auteurRepository->findAllArrayWithBooks($query);
        $annonce = $annonceRepository->findAllArray($query);
        
        $logger->info($query);


        // return $this->json($listAuteur);
        return new JsonResponse($annonce);
    }
//========================== recherche filter =====================================================
    /**
     * @Route("/filter", name="filter_annonces", methods={"GET","POST"})
     */
    public function filter(Request $request): Response{
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesSearchType::class);
        $form->handleRequest($request);

        /* dd($request->request->get('annonces_search'));
        dd($request->request->get('annonces_search')['superficie']);
        dd($request->request->get('annonces_search')['spf_chambre']);
        dd($request->request->get('annonces_search')['prix']);
        dd($request->request->get('annonces_search')['type_logement'][0]);
        dd($request->request->get('annonces_search')['equipements']);
        dd($request->request->get('annonces_search')['type_logement'][0]);
        dd($request->request->get('annonces_search')['pref_genre'][0]); */
        /* dd($request->request->get('annonces_search')['animaux']); */
       /*  dd($request->request->get('annonces_search')['fumeur']); */
        //$prix = $request->request->get('annonces_search')['prix']; 
       
        $prix = $request->request->get('annonces_search')['prix'];
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $request = $em->createQueryBuilder('a');
            $request->select('a');

            if(isset($prix)){
                 
                $request->andwhere('a.prix <= prix')
                ->setParameter('prix',  $prix ); 
            }

            $data = $request->getQuery()->getResult();

            dd($data);

            /* if($request->get('supêrficie') > 50){

                $em->where('superficie > :superficieValue');
                $em->setParameter('superficieValue', $request->get('supêrficie'));

            }*/

           /*  $qb->getQuery()->getResult(); */

        } 


        
        return $this->render('annonces/filter-annonce.html.twig', [
            'annonces' => $annonce,
            'form' => $form->createView(),
            /* 'data' => $data */
        ]);
    }



    /**
     * @Route("/{id}", name="annonces_show", methods={"GET"})
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonces $annonce): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setDateCreation(new DateTime());

            $file = $form->get('img1')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg1($fileName);
            }

            $file = $form->get('img2')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg2($fileName);
            }


            $file = $form->get('img3')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg3($fileName);
            }

            $file = $form->get('img4')->getData();
            if (isset($file)) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $annonce->setImg4($fileName);
            }


            $annonce->setUser($this->getUser());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('annonces/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonces $annonce): Response
    {
        
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonces_index');
    }

    
}

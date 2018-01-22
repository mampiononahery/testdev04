<?php

namespace App\Bundle\MainBundle\Controller;

use App\Bundle\MainBundle\Entity\Annonces;
use App\Bundle\MainBundle\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File;


use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;

class AnnoncesController extends BaseController
{
    public function indexAction()
    {
        // Create a basic QR code
//        $qrCode = new QrCode('Life is too short to be generating QR codes');
//        $qrCode->setSize(300);
//
//        $rootDir = $this->get('kernel')->getRootDir() ;
//
//        // Set advanced options
//        $qrCode
//            ->setWriterByName('png')
//            ->setMargin(10)
//            ->setEncoding('UTF-8')
//            ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
//            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
//            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
//            ->setLabel('Scan the code', 16, $rootDir.'/../assets/noto_sans.otf', LabelAlignment::CENTER)
//            ->setLogoWidth(150)
//            ->setValidateResult(false)
//        ;
//
//        // Directly output the QR code
//        header('Content-Type: '.$qrCode->getContentType());
//        echo $qrCode->writeString();

        $categories = $this->getDoctrine()->getRepository('AppMainBundle:Categories')->findAll() ;

        return $this->render('AppMainBundle:Annonces:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates nouvelle annonce.
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser() ;

        if (null == $user) {
            $this->get('session')->getFlashBag()->add('error', 'Veuillez vous connecter ou créer un compte pour pouvoir crée une annonce.') ;

            return $this->redirectToRoute('login_front', array(), 307) ;
        }

        $annonce = new Annonces() ;
        $form = $this->createForm(AnnoncesType::class, $annonce) ;
        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceManager = $this->get('jolydays_dev4_annonce_manager') ;
            $files = $request->files->get('app_bundle_mainbundle_annonces')['picture'] ;
            $uploadFile = $this->get('jolydays_dev4_upload_file') ;
            $fileName = $uploadFile->upload($files) ;
            $annonce->setPicture($fileName) ;
            $annonceManager->save($annonce) ;
            $toCategories = $annonce->getCategorie()->toArray() ;

            foreach ($toCategories as $categorie) {
                $categorie->addAnnonce($annonce) ;
                $annonceManager->save($categorie) ;
            }


            $this->get('session')->getFlashBag()->add('success', 'L\'annonce a été crée avec succès.') ;

            return $this->redirectToRoute('app_main_homepage') ;
        }

        return $this->render('AppMainBundle:Annonces:new.html.twig', array(
            'form' => $form->createView(),
        )) ;
    }

    /**
     * Edition annonce
     *
     * @param Request $request
     * @param Annonces $annonce
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function editAction(Request $request, Annonces $annonce)
    {
        $user = $this->getUser() ;

        if (null == $user) {
            $this->get('session')->getFlashBag()->add('error', 'Veuillez vous connecter ou créer un compte pour pouvoir crée une annonce.') ;

            return $this->redirectToRoute('login_front', array(), 307) ;
        }

        $path = $this->getParameter('upload_directory') ;

        if (null !== $annonce->getPicture()) {
            $file = new File\File($path.$annonce->getPicture(), $path.$annonce->getPicture(), null, null, null, true) ;
            $annonce->setPicture($file) ;
        }
        
        $form = $this->createForm(AnnoncesType::class, $annonce) ;
        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid()) {

            $annonceManager = $this->get('jolydays_dev4_annonce_manager') ;
            $files = $request->files->get('app_bundle_mainbundle_annonces')['picture'] ;
            $uploadFile = $this->get('jolydays_dev4_upload_file') ;
            $fileName = $uploadFile->upload($files) ;
            $annonce->setPicture($fileName) ;
            $annonceManager->save($annonce) ;
            $toCategories = $annonce->getCategorie()->toArray() ;

            foreach ($toCategories as $categorie) {
                $categorie->removeAnnonce($annonce) ;
                $categorie->addAnnonce($annonce) ;
                $annonceManager->save($categorie) ;
            }

            $this->get('session')->getFlashBag()->add('success', 'L\'annonce a été moidifié avec succès.') ;

            return $this->redirectToRoute('app_main_homepage') ;
        }

        return $this->render('AppMainBundle:Annonces:edit.html.twig', array(
            'form' => $form->createView(),
            'annonce' => $annonce,
        )) ;
    }

    /**
     * Ajax find list categories.
     *
     * @return JsonResponse
     */
    public function retrieveDataAjaxAction(Request $request)
    {
        $filters  = $this->getFilters($request) ;
        $sortings = $this->getSortings($request, array(
            'a.id',
        )) ;

        $annonceManager = $this->get('jolydays_dev4_annonce_manager') ;

        $options = array(
            'search' => $request->query->get('sSearch'),
            'query'  => $request->query->get('sQuery'),
        );

        $tNbAnnounces  = $annonceManager->countBy($options);
        $tAnnounces    = $annonceManager->findByCriteria($options, $filters, $sortings)->getResult();

        $content = $this->getDataJson (
            $request,
            $tNbAnnounces['nbAnnonce'],
            $tNbAnnounces['nbAnnonce'],
            $tAnnounces,
            'AppMainBundle:Annonces:index.json.html.twig'
        ) ;

        $response = new Response($content);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}

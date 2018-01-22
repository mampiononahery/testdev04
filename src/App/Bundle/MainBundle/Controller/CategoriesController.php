<?php

namespace App\Bundle\MainBundle\Controller;

use App\Bundle\MainBundle\Entity\Categories;
use App\Bundle\MainBundle\Form\CategoriesType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File;

class CategoriesController extends BaseController
{
    /**
     * Creates nouvelle categorie.
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();

        if (null == $user) {
            $this->get('session')->getFlashBag()->add('error', 'Veuillez vous connecter ou créer un compte pour pouvoir crée une annonce.');

            return $this->redirectToRoute('login_front', array(), 307);
        }

        $categorie = new Categories();
        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceManager = $this->get('jolydays_dev4_annonce_manager');
            $annonceManager->save($categorie);

            $this->get('session')->getFlashBag()->add('success', 'Catégorie crée avec succès.');

            return $this->redirectToRoute('app_main_homepage');
        }

        return $this->render('AppMainBundle:Categories:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

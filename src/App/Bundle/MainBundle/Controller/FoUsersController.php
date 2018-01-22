<?php

namespace App\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class FoUsersController extends Controller
{
    /**
     * Creates a new user front.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction (Request $request)
    {
        if ( "POST" === $request->getMethod() )
        {
            try {
                $userManager = $this->get('fos_user.user_manager');

                $user = $userManager->createUser();
                $user->setEnabled(true);

                $formFactory = $this->get('fos_user.registration.form.factory');
                $form = $formFactory->createForm();
                $form->setData($user);

                $form->handleRequest($request);

                if ($form->isSubmitted()) {
                    $userManager->updateUser($user);
                }

                $zMessage = 'Utilisateur crée avec succes' ;
                $iStatus  = 200 ;
            }
            catch ( \Exception $e ) {
                $zMessage = sprintf('%s', $e->getMessage()) ;
                $iStatus  = 400 ;
            }

            return new JsonResponse(
                array(
                    'status'  => $iStatus,
                    'message' => $zMessage,
                ),
                200,
                array('Content-Type' => 'application/json')) ;

        }

        return $this->render('@AppMain/Security/login.html.twig', array());
    }
}

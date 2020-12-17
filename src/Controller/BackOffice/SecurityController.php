<?php

namespace App\Controller\BackOffice;

use App\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/login", name="backoffice_login")
     */
    public function login(
        AuthenticationUtils $authenticationUtils,
        Request $request
    ) {
        $loginForm = $this
            ->createForm(LoginType::class, null, [
                'action' => $this->generateUrl('backoffice_login')
            ])
            ->handleRequest($request);

        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('back_office/security/login.html.twig', [
            'loginForm'    => $loginForm->createView(),
            'error'        => $error,
            'lastUsername' => $lastUsername,
        ]);
    }

    /**
     * @Route("/logout", name="backoffice_logout")
     */
    public function logout(){}
}

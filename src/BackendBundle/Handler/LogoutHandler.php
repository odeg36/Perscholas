<?php

namespace BackendBundle\Handler;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;

class LogoutHandler implements LogoutSuccessHandlerInterface {

    protected $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request) {
        // redirect the user to where they were before the login process begun.
        $mensaje = $request->get('no_access');
        if ($mensaje) {
            $request->getSession()->getFlashBag()->add('sonata_flash_error', 'El usuario ingresado no tiene acceso a esta sección del sistema');
        }
        $url = $this->router->generate('fos_user_security_login');

        $response = new RedirectResponse($url);
        return $response;
    }

}
<?php

namespace BackendBundle\Handler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    private $router;
    private $container;

    public function __construct(Router $router, ContainerInterface $container) {
        $this->router = $router;
        $this->container = $container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        // If the user tried to access a protected resource and was forces to login
        // redirect him back to that resource
        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN') || $this->container->get('security.context')->isGranted('ROLE_GESTOR')) {
            $refererUri = $request->getSession()->get('_security.target_path');
            $url = $refererUri && $refererUri != $request->getUri() ? $refererUri : $this->router->generate('sonata_admin_dashboard');
        } else {
            $refererUri = $request->getSession()->get('_security.target_path');
            $url = $refererUri && $refererUri != $request->getUri() ? $refererUri : $this->router->generate('frontend_homepage');
        }

        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        // Create a flash message with the authentication error message
        $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('fos_user_security_login');

        return new RedirectResponse($url);
    }

}
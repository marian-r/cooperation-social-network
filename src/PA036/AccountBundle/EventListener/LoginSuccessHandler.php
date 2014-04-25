<?php
namespace PA036\AccountBundle\EventListener;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Doctrine\ORM\EntityManager;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $security;
    protected $em;


    public function __construct(Router $router, SecurityContext $security, EntityManager $entityManager) {
        $this->router = $router;
        $this->security = $security;
        $this->em = $entityManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        
        $user = $token->getUser();
        $user->setLastLogin(new \DateTime());

        $this->em->merge($user);
        $this->em->flush();

        $response = new RedirectResponse($this->router->generate('home'));
        
        return $response;
    }

}
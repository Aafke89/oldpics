<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 20/09/16
 * Time: 11:00
 */

namespace AppBundle\Security;


use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, Router $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router =$router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
        if (!$isLoginSubmit){
            return null;
        }

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
       $username = $credentials['_username'];
        $user = $this->em->getRepository('AppBundle:User')
            ->findOneBy(['username' => $username]);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }
        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('user_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }










}
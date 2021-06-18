<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator,
                                CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // dd($request->request->all());
        //        $request->getSession()->set(
//            Security::LAST_USERNAME,
//            $credentials['email']
//        );

        return [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('csrf_token'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {


        //dd($credentials);
//        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
//        if (!$this->csrfTokenManager->isTokenValid($token)) {
//            throw new InvalidCsrfTokenException();
//        }
//
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['userName' => $credentials['username']]);
        //dd($user);
//
//        if (!$user) {
//            throw new UsernameNotFoundException('Email could not be found.');
//        }
//
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        //dd($user);
        //return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        return true;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
//    public function getPassword($credentials): ?string
//    {
//        //return $credentials['password'];
//    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('micro_post_index'));
//        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
//            return new RedirectResponse($targetPath);
//        }
//
//        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
//        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        // return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}

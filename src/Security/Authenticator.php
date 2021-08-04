<?php


namespace App\Security;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class Authenticator extends AbstractAuthenticator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request): PassportInterface
    {
        $login = $request->request->get('login');
        $pwd = $request->request->get('password');
        return new Passport(
            new UserBadge($login, function ($userIdentifier) {
                return $this->userRepository->findOneBy(['login' => $userIdentifier]);
            }),
            new PasswordCredentials($pwd)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    // если передается auth, значит будет вызван метод authenticate по проверке логина и пароля
    // и создании пользовательской сессии
    public function supports(Request $request): ?bool
    {
        return  $request->request->has('auth');
    }

    // если пользователь не прошел авторизацию
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['message' => 'error'], Response::HTTP_UNAUTHORIZED);
    }
}
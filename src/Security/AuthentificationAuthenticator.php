<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AuthentificationAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Access the authenticated user
        $user = $token->getUser();

        // Check if the user has specific roles and redirect accordingly
        if ($user instanceof UserInterface) {
            // Example: Check for "ROLE_ADMIN" or any other custom roles like "ROLE_PARTENAIRE"
            if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                return new RedirectResponse($this->urlGenerator->generate('app_user_index')); // Redirect to admin dashboard
            }
            if (in_array('ROLE_PARTENAIRE', $user->getRoles(), true)) {
                return new RedirectResponse($this->urlGenerator->generate('partenaire_dashboard')); // Redirect to partenaire dashboard
            }
            if (in_array('ROLE_ORGANISATEUR', $user->getRoles(), true)) {
                return new RedirectResponse($this->urlGenerator->generate('organisateur_dashboard')); // Redirect to organisateur dashboard
            }
            if (in_array('ROLE_PARTICIPANT', $user->getRoles(), true)) {
                return new RedirectResponse($this->urlGenerator->generate('participant_dashboard')); // Redirect to organisateur dashboard
            }
        }

        // Default redirection after login if no specific role
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Redirect to app_home after successful login (default behavior)
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}


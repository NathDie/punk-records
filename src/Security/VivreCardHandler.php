<?php

namespace App\Security;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final readonly class VivreCardHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        #[Autowire('%env(VIVRE_CARD_KEY)%')] private string $vivreCardKey,
    ) {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        if (!hash_equals($this->vivreCardKey, $accessToken)) {
            throw new BadCredentialsException();
        }

        return new UserBadge(
            'stella',
            static fn () => new InMemoryUser('stella', null, ['ROLE_STELLA']),
        );
    }
}

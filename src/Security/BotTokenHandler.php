<?php

namespace App\Security;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final readonly class BotTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        #[Autowire('%env(BOT_API_TOKEN)%')] private string $botToken,
    ) {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        if (!hash_equals($this->botToken, $accessToken)) {
            throw new BadCredentialsException();
        }

        return new UserBadge(
            'discord-bot',
            static fn () => new InMemoryUser('discord-bot', null, ['ROLE_BOT']),
        );
    }
}

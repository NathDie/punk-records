<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

final class VivreCardExtractor implements AccessTokenExtractorInterface
{
    public const HEADER = 'Vivre-Card';

    public function extractAccessToken(Request $request): ?string
    {
        $value = $request->headers->get(self::HEADER);

        return \is_string($value) && '' !== $value ? $value : null;
    }
}

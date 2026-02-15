<?php

namespace RandomPHP\GCM;

final class DecodedCipher
{
    public function __construct(
        public readonly EncryptionVersion $version,
        public readonly string $nonce,
        public readonly string $cipherText,
        public readonly string $tag,
    ) {
    }
}
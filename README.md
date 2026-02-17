![RandomPHP](./assets/randomphp_text.png)

# RandomPHP GCM

Secure string encryption/decryption using **AES-256-GCM** (authenticated encryption) built on **phpseclib v3**.

---

## Requirements

- **PHP >= 8.1**
- `phpseclib/phpseclib ~3.0`

---

## Installation

```bash
composer require randomphp/gcm
```

---

## Usage

### Encrypt

```php
<?php

use RandomPHP\GCM\Encryptor;
use RandomPHP\GCM\EncryptionVersion;

$key = random_bytes(32); // 32 bytes (256-bit) recommended for AES-256

$cipherText = Encryptor::encrypt(
    plainText: "Hello World!",
    key: $key,
    version: EncryptionVersion::V2 // optional (default: V2)
);

echo $cipherText;
```

### Decrypt

`decrypt()` automatically detects the cipher format/version.

```php
<?php

use RandomPHP\GCM\Encryptor;

$key = /* the same key used for encryption */;

$plainText = Encryptor::decrypt(
    cipherText: $cipherText,
    key: $key
);

echo $plainText;
```

### Decode (inspect parts)

If you want to inspect the nonce/tag/ciphertext components without decrypting:

```php
<?php

use RandomPHP\GCM\Encryptor;

$decoded = Encryptor::decode($cipherText);

var_dump($decoded->version);    // EncryptionVersion::V1 or V2
var_dump($decoded->nonce);      // raw bytes
var_dump($decoded->cipherText); // raw bytes
var_dump($decoded->tag);        // raw bytes
```

> Note: the values returned by `decode()` are **raw binary strings** (bytes). Convert to hex/base64 if you want them readable.

---

## Error Handling

The library throws dedicated exceptions under `RandomPHP\GCM\Exceptions`:

- `EncryptionException`
- `DecryptionException`
- `DecodingException`

Example:

```php
<?php

use RandomPHP\GCM\Encryptor;
use RandomPHP\GCM\Exceptions\EncryptionException;
use RandomPHP\GCM\Exceptions\DecryptionException;
use RandomPHP\GCM\Exceptions\DecodingException;

try {
    $key = random_bytes(32);
    $cipherText = Encryptor::encrypt("Secret data", $key);
    $plainText  = Encryptor::decrypt($cipherText, $key);
} catch (EncryptionException | DecryptionException | DecodingException $e) {
    // Handle error (log, fail request, etc.)
    echo $e->getMessage();
}
```

---

## Security Notes

- Use a strong, secret key. **32 bytes** is recommended for AES-256 (`random_bytes(32)`).
- Do not reuse nonces (this library generates a fresh nonce per encryption).
- Protect keys (env vars / secrets manager). Never commit keys to source control.

---

## Tests

```bash
composer install
vendor/bin/phpunit
```


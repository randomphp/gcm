# RandomPHP - GCM

### Usage

```php
<?php

use RandomPHP\GCM\Encryptor;
use RandomPHP\GCM\EncryptionVersion;

require_once __DIR__ . '/vendor/autoload.php';

$key = '<keys-should-32-characters-long>';
$data = 'The quick brown fox jumps over the lazy dog';

// Encrypt Data.
// It's recommended to use version 2 for all new data, V1 is only here for backwards compatibility.
$encryptedString = Encryptor::encrypt(
    plainText: $data,
    key: $key,
    version: EncryptionVersion::V2 // (This argument is optional) Defaults to EncryptionVersion::V2
);

// Decrypt Data.
$decryptedData = Encryptor::decrypt(
    cipherText: $encryptedString,
    key: $key
);

//Should output: "The quick brown fox jumps over the lazy dog"
echo $decryptedData;
```
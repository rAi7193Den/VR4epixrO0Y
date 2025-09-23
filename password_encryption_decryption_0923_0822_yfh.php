<?php
// 代码生成时间: 2025-09-23 08:22:33
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class PasswordEncryptionDecryptionTool
{

    protected $key;

    /**
     * Constructor to set the encryption key.
     *
     * @param string $key The encryption key.
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Encrypt a password using Laravel's Hashing.
     *
     * @param string $password The password to encrypt.
     * @return string The encrypted password.
     * @throws Exception If the encryption fails.
     */
    public function encrypt($password)
    {
        try {
            return Hash::make($password);
        } catch (Exception $e) {
            throw new Exception('Encryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt a password using Laravel's Hashing (for verification).
     *
     * @param string $hashedPassword The hashed password to verify.
     * @param string $password The password to compare with the hashed password.
     * @return bool True if the password matches the hashed password, otherwise false.
     * @throws Exception If the decryption fails.
     */
    public function decrypt($hashedPassword, $password)
    {
        try {
            return Hash::check($password, $hashedPassword);
        } catch (Exception $e) {
            throw new Exception('Decryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt a value using Laravel's Crypt.
     *
     * @param string $value The value to encrypt.
     * @return string The encrypted value.
     * @throws Exception If the encryption fails.
     */
    public function encryptWithCrypt($value)
    {
        try {
            return Crypt::encryptString($value);
        } catch (Exception $e) {
            throw new Exception('Encryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt a value using Laravel's Crypt.
     *
     * @param string $encryptedValue The encrypted value to decrypt.
     * @return string The decrypted value.
     * @throws Exception If the decryption fails.
     */
    public function decryptWithCrypt($encryptedValue)
    {
        try {
            return Crypt::decryptString($encryptedValue);
        } catch (Exception $e) {
            throw new Exception('Decryption failed: ' . $e->getMessage());
        }
    }

}

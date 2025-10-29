<?php
// 代码生成时间: 2025-10-29 19:33:44
use Illuminate\Support\Facades\Validator;

class DataMaskingTool 
{
    /**
     * Masks an email address.
     *
     * @param string $email The email address to be masked.
     * @return string The masked email address.
     * @throws InvalidArgumentException If the email is not valid.
     */
    public function maskEmail($email) 
    {
        $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
        
        if ($validator->fails()) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }
        
        // Replace all but the last two characters of the local part with asterisks.
        $localPart = substr($email, 0, strpos($email, '@'));
        $domain = substr($email, strpos($email, '@'));
        $maskedLocalPart = str_repeat('*', strlen($localPart) - 2) . substr($localPart, -2);
        
        return $maskedLocalPart . $domain;
    }

    /**
     * Masks a phone number.
     *
     * @param string $phone The phone number to be masked.
     * @return string The masked phone number.
     */
    public function maskPhone($phone) 
    {
        // Replace all but the last four digits with asterisks.
        return str_repeat('*', strlen($phone) - 4) . substr($phone, -4);
    }

    // Additional methods for other types of data masking can be added here.
}

// Example usage:

try {
    $maskingTool = new DataMaskingTool();
    $maskedEmail = $maskingTool->maskEmail("example@email.com");
    echo "Masked Email: " . $maskedEmail . "\
";
    
    $maskedPhone = $maskingTool->maskPhone("1234567890");
    echo "Masked Phone: " . $maskedPhone . "\
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

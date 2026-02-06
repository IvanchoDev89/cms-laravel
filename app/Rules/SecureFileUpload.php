<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class SecureFileUpload implements ValidationRule
{
    /**
     * Create a new rule instance.
     */
    public function __construct(
        private readonly array $allowedMimes = [
            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp',
            'mp4', 'avi', 'mov', 'wmv',
            'mp3', 'wav', 'ogg',
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
            'txt', 'csv', 'zip', 'rar', '7z',
        ],
        private readonly int $maxSize = 10240, // 10MB in KB
        private readonly array $blockedPatterns = [
            '/\.php$/i',
            '/\.phtml$/i',
            '/\.exe$/i',
            '/\.bat$/i',
            '/\.cmd$/i',
            '/\.scr$/i',
            '/\.js$/i',
            '/\.vbs$/i',
        ]
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('The :attribute must be a file.');

            return;
        }

        // Check file extension
        $extension = strtolower($value->getClientOriginalExtension());
        if (! in_array($extension, $this->allowedMimes)) {
            $fail('The :attribute must be a file of type: '.implode(', ', $this->allowedMimes).'.');

            return;
        }

        // Check for dangerous file patterns
        $filename = $value->getClientOriginalName();
        foreach ($this->blockedPatterns as $pattern) {
            if (preg_match($pattern, $filename)) {
                $fail('The :attribute contains a potentially dangerous file type.');

                return;
            }
        }

        // Check file size
        if ($value->getSize() > $this->maxSize * 1024) {
            $fail("The :attribute may not be greater than {$this->maxSize} kilobytes.");

            return;
        }

        // Additional security checks for images
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $this->validateImage($value, $fail);
        }
    }

    /**
     * Validate image files for embedded threats.
     */
    private function validateImage(UploadedFile $file, Closure $fail): void
    {
        // Get image info
        $imageInfo = @getimagesize($file->getPathname());

        if ($imageInfo === false) {
            $fail('The :attribute appears to be corrupted or is not a valid image.');

            return;
        }

        // Check for embedded PHP in images
        $content = file_get_contents($file->getPathname());
        if (strpos($content, '<?php') !== false) {
            $fail('The :attribute contains potentially malicious content.');

            return;
        }
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The file upload failed security validation.';
    }
}

<?php

namespace App\Dto\Registration;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 5, max: 50, minMessage: "The password must be at least 5 characters long", maxMessage: "The password must be maximum 50 characters long")]
        public readonly string $password,
    ) {
    }
}

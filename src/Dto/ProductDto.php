<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public int $id
    )
    {
    }

}
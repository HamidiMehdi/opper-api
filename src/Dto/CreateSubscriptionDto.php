<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateSubscriptionDto
{
    public function __construct(
        #[Assert\NotBlank]
        public ContactDto $contact,

        #[Assert\NotBlank]
        public ProductDto $product,

        #[Assert\NotBlank]
        public \Datetime $beginDate,

        #[Assert\NotBlank]
        public \Datetime $endDate,
    ) {
    }

}
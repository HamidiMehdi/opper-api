<?php

namespace App\Dto;

class EditSubscriptionDto
{
    public function __construct(
        #[Assert\NotBlank]
        public ?ContactDto $contact,

        #[Assert\NotBlank]
        public ?ProductDto $product,

        #[Assert\NotBlank]
        public ?\Datetime $beginDate,

        #[Assert\NotBlank]
        public ?\Datetime $endDate,
    ) {
    }
}
<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class Insert
{
    #[Assert\Type('integer')]
    public ?int $integer;
    #[Assert\Type('string')]
    public ?string $string;
}
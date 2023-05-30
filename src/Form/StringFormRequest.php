<?php declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class StringFormRequest
{
    #[Assert\Type('string'), Assert\NotBlank()]
    public string $string;
}

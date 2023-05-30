<?php declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class IntegerFormRequest
{
    #[Assert\Type('integer'), Assert\NotBlank()]
    public int $integer;
}

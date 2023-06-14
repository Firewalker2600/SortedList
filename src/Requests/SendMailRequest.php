<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class SendMailRequest extends ApiRequest
{
    public const TEMPLATES = ['expiration'];

    #[Assert\NotBlank(), Assert\Choice(choices: SendMailRequest::TEMPLATES)]
    public string $key; // name of mail template

    #[Assert\NotBlank(), Assert\Type('string')]
    public string $subject; //email subject
    #[Assert\NotBlank(), Assert\Collection(
        fields: [
         'id' => [
             new Assert\NotBlank(),
             new Assert\Type('string'),
         ],
         'date' => new Assert\DateTime('Y-m-d'),
         'link' => new Assert\Collection(
             fields: [
                 'url' => [
                     new Assert\Url(),
                     new Assert\NotBlank(),
                ],
                 'label' => new Assert\Type('string'),
             ]
         )
        ]
    )]
    public array $body_data; // parameters for the email template
    #[Assert\NotNull, Assert\AtLeastOneOf([
        new Assert\IsFalse,
        new Assert\DateTime('Y-m-d'),
    ])]
    public bool|\DateTime $delay_send;

    #[Assert\NotBlank, Assert\AtLeastOneOf([
        new Assert\Email,
        new Assert\All(
            new Assert\Email
        )
    ])]
    public string|array $email; //target email address

    #[Assert\AtLeastOneOf([
        new  Assert\Email,
        new Assert\All(
            new Assert\Email
        )
    ])]
    public null|string|array $bcc = null; //  hidden copy email address

    public function getAll(): array
    {
        return [
            "key" => $this->key,
            "subject" => $this->subject,
            "body_data" => $this->body_data,
            "delay_send" => $this->delay_send,
            "email" => $this->email,
            "bcc" => $this->bcc,
        ];
    }
}

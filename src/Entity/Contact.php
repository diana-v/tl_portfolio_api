<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank
     * @Assert\Length (
     *     max = 30,
     * )
     */
    private $name;

    /**
     * @Assert\Email(
     *     message = "Jūsų el. paštas '{{ value }}' nėra teisingas."
     * )
     */
    protected $email;

    /**
     * @Assert\Length(
     *     allowEmptyString="false",
     *      min = 10,
     *      max = 250,
     *      minMessage = "Jūsų žinutė turi būti bent '{{ limit }}' ženklų.",
     *      maxMessage = "Jūsų žinutė negali būti daugiau nei '{{ limit }}' ženklų."
     * )
     * @Assert\NotBlank
     */
    protected $message;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}
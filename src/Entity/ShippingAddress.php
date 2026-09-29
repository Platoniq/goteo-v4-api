<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class ShippingAddress
{
    public function __construct(
        /**
         * First name(s) of the person receiving the shipment.
         */
        #[Assert\NotBlank()]
        #[ORM\Column(length: 255)]
        public readonly string $firstName,

        /**
         * Last name(s) of the person receiving the shipment.
         */
        #[Assert\NotBlank()]
        #[ORM\Column(length: 255)]
        public readonly string $lastName,

        /**
         * Line 1: usually street name and number.
         */
        #[Assert\NotBlank()]
        #[ORM\Column(length: 255)]
        public readonly string $addressLine1,

        /**
         * Line 2: additional data like apartment number, door, etc.
         */
        #[ORM\Column(length: 255, nullable: true)]
        public readonly ?string $addressLine2,

        /**
         * Name of the city, or the lowest-available type of settlement to which the address lines belong.
         */
        #[Assert\NotBlank()]
        #[ORM\Column(length: 255)]
        public readonly string $city,

        /**
         * Postal/PIN/ZIP code to which the address lines belong.
         */
        #[Assert\NotBlank()]
        #[ORM\Column(length: 255)]
        public readonly string $postCode,

        /**
         * ISO 3166-1 alpha-2 two-letter country code.\
         * e.g: ES (Spain).
         */
        #[Assert\NotBlank()]
        #[Assert\Country(alpha3: false)]
        #[ORM\Column(length: 2)]
        public readonly string $country,
    ) {}

    public function tryFrom(mixed $value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        if (\is_array($value)) {
            return new self(
                $value['firstName'],
                $value['lastName'],
                $value['addressLine1'],
                array_key_exists('addressLine2', $value) ? $value['addressLine2'] : null,
                $value['city'],
                $value['postCode'],
                $value['country']
            );
        }

        throw new \Exception("Could not get a ShippingAddress object from value");
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}

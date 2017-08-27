<?php
namespace Application\Club;

class GetClubsBySearchQuery
{
    private $locale;
    private $name;
    private $manager;

    private function __construct(string $locale, string $name, string $manager)
    {
        $this->locale = $locale;
        $this->name = $name;
        $this->manager = $manager;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getManager(): string
    {
        return $this->manager;
    }

    public static function create(string $locale, string $name, string $manager): self
    {
        return new self($locale, $name, $manager);
    }

}
<?php
namespace Application\Language;

class CreateLanguageCommand
{
    private $locale;
    private $name;

    private function __construct(string $locale, string $name)
    {
        $this->locale = $locale;
        $this->name = $name;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(string $locale, string $name): self
    {
        return new self($locale, $name);
    }
}
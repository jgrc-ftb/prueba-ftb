<?php
namespace Application\Language;

class RemoveLanguageCommand
{
    private $locale;

    private function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public static function create(string $locale): self
    {
        return new self($locale);
    }

}
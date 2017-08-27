<?php
namespace Application\Club;

class RemoveClubTranslationCommand
{
    private $club;
    private $language;

    private function __construct(string $club, string $language)
    {
        $this->club = $club;
        $this->language = $language;
    }

    public function getClub(): string
    {
        return $this->club;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public static function create(string $club, string $language): self
    {
        return new self($club, $language);
    }
}
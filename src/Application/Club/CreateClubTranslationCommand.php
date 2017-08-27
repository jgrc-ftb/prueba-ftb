<?php
namespace Application\Club;

class CreateClubTranslationCommand
{
    private $club;
    private $language;
    private $description;

    private function __construct(string $club, string $language, string $description)
    {
        $this->club = $club;
        $this->language = $language;
        $this->description = $description;
    }

    public function getClub(): string
    {
        return $this->club;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function create(string $club, string $language, string $description): self
    {
        return new self($club, $language, $description);
    }
}
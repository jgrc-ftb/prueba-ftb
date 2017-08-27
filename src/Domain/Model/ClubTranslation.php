<?php
namespace Domain\Model;

class ClubTranslation
{
    private $club;
    private $language;
    private $description;

    private function __construct()
    {
    }

    private function setDescription(string $description): self
    {
        if (1 !== preg_match('/^.+$/', $description)) {
            throw new \InvalidArgumentException('Club Translation description cant be empty.');
        }
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    private function setClub(Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getClub(): Club
    {
        return $this->club;
    }

    private function setLanguage(Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public static function create(Club $club, Language $language, string $description): self
    {
        return (new self())
            ->setClub($club)
            ->setLanguage($language)
            ->setDescription($description);
    }
}

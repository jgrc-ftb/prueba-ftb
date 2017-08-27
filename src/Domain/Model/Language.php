<?php
namespace Domain\Model;

class Language
{
    private $id;
    private $name;

    private function __construct()
    {
    }

    private function setId(string $id): self
    {
        if (1 !== preg_match('/^[a-z]{2}$/', $id)) {
            throw new \InvalidArgumentException('Language id should be a valid locale ISO.');
        }
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function setName(string $name): self
    {
        if (1 !== preg_match('/^.+$/', $name)) {
            throw new \InvalidArgumentException('Language name cant be empty.');
        }
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(string $id, string $name): self
    {
        return (new self)
            ->setId($id)
            ->setName($name);
    }
}

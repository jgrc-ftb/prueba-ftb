<?php
namespace Application\Club;

class CreateClubCommand
{
    private $name;
    private $manager;

    private function __construct(string $name, string $manager)
    {
        $this->name = $name;
        $this->manager = $manager;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getManager(): string
    {
        return $this->manager;
    }

    public static function create(string $name, string $manager): self
    {
        return new self($name, $manager);
    }
}
<?php
namespace Application\Club;

class RemoveClubCommand
{
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function create(string $id): self
    {
        return new self($id);
    }
}
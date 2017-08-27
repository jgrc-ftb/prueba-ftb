<?php
namespace Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Club
{

    private $id;
    private $name;
    private $manager;
    private $clubTranslations;

    private function __construct()
    {
        $this->clubTranslations = new ArrayCollection();
    }

    private function setId(string $id): self
    {
        if (1 !== preg_match('/^.+$/', $id)) {
            throw new \InvalidArgumentException('Club id cant be empty.');
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
            throw new \InvalidArgumentException('Club name cant be empty.');
        }
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setManager(string $manager): self
    {
        if (1 !== preg_match('/^.+$/', $manager)) {
            throw new \InvalidArgumentException('Club manager cant be empty.');
        }
        $this->manager = $manager;

        return $this;
    }

    public function getManager(): string
    {
        return $this->manager;
    }

    public function getClubTranslations(): Collection
    {
        return $this->clubTranslations;
    }

    public static function create(string $name, string $manager): self
    {
        return (new self)
            ->setId(Uuid::uuid4())
            ->setName($name)
            ->setManager($manager);
    }

    public function getFirstDescription(): string
    {
        return $this->getClubTranslations()->count() > 0 ?
            $this->getClubTranslations()->get(0)->getDescription() : '';
    }
}

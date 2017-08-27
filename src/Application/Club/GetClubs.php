<?php
namespace Application\Club;

use Domain\Model\ClubRepository;

class GetClubs
{
    private $clubRepository;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function ask(): array
    {
        return $this
            ->clubRepository
            ->findAll();
    }
}
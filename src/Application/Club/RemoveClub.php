<?php
namespace Application\Club;

use Domain\Model\ClubRepository;

class RemoveClub
{
    private $clubRepository;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function handle(RemoveClubCommand $command): void
    {
        $this
            ->clubRepository
            ->remove(
                $this
                    ->clubRepository
                    ->findOrFail(
                        $command->getId()
                    )
            );
    }
}
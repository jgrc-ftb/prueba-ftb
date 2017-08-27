<?php
namespace Application\Club;

use Domain\Model\Club;
use Domain\Model\ClubRepository;

class CreateClub
{
    private $clubRepository;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function handle(CreateClubCommand $command): Club
    {
        return $this
            ->clubRepository
            ->add(
                Club::create(
                    $command->getName(),
                    $command->getManager()
                )
            );
    }
}
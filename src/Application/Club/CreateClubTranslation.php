<?php
namespace Application\Club;

use Domain\Model\ClubRepository;
use Domain\Model\ClubTranslation;
use Domain\Model\LanguageRepository;

class CreateClubTranslation
{
    private $clubRepository;
    private $languageRepository;

    public function __construct(
        ClubRepository $clubRepository,
        LanguageRepository $languageRepository
    ) {
        $this->clubRepository = $clubRepository;
        $this->languageRepository = $languageRepository;
    }

    public function handle(CreateClubTranslationCommand $command): ClubTranslation
    {
        return $this
            ->clubRepository
            ->addClubTranslation(
                ClubTranslation::create(
                    $this
                        ->clubRepository
                        ->findOrFail(
                            $command->getClub()
                        ),
                    $this
                        ->languageRepository
                        ->findOrFail(
                            $command->getLanguage()
                        ),
                    $command->getDescription()
                )
            );
    }
}
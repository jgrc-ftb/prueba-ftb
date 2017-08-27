<?php
namespace Application\Club;

use Domain\Model\ClubRepository;
use Domain\Model\LanguageRepository;

class RemoveClubTranslation
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

    public function handle(RemoveClubTranslationCommand $command): void
    {
        $this
            ->clubRepository
            ->removeClubTranslation(
                $this
                    ->clubRepository
                    ->findClubTranslationOrFail(
                        $this
                            ->clubRepository
                            ->findOrFail(
                                $command->getClub()
                            ),
                        $this
                            ->languageRepository
                            ->findOrFail(
                                $command->getLanguage()
                            )
                    )
            );
    }
}
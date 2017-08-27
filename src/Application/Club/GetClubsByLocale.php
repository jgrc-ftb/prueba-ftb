<?php
namespace Application\Club;

use Domain\Model\ClubRepository;
use Domain\Model\LanguageRepository;

class GetClubsByLocale
{
    private $languageRepository;
    private $clubRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        ClubRepository $clubRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->clubRepository = $clubRepository;
    }

    public function ask(GetClubsByLocaleQuery $query): array
    {
        return $this
            ->clubRepository
            ->findAllByLanguage(
                $this
                    ->languageRepository
                    ->findOrFail($query->getLocale())
            );
    }
}
<?php
namespace Application\Club;

use Domain\Model\ClubRepository;
use Domain\Model\LanguageRepository;

class GetClubsBySearch
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

    public function ask(GetClubsBySearchQuery $query): array
    {
        return $this
            ->clubRepository
            ->findBySearch(
                $this
                    ->languageRepository
                    ->findOrFail($query->getLocale()),
                $query->getName(),
                $query->getManager()
            );
    }
}
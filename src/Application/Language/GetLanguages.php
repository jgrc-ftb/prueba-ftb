<?php
namespace Application\Language;

use Domain\Model\LanguageRepository;

class GetLanguages
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function ask(): array
    {
        return $this
            ->languageRepository
            ->findAll();
    }
}
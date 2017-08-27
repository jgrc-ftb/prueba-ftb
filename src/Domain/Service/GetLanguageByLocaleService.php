<?php
namespace Domain\Service;

use Domain\Model\Language;
use Domain\Model\LanguageRepository;

class GetLanguageByLocaleService
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function execute(string $locale): Language
    {
        return $this->languageRepository->findOrFail($locale);

    }
}
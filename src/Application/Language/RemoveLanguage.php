<?php
namespace Application\Language;

use Domain\Model\LanguageRepository;

class RemoveLanguage
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function handle(RemoveLanguageCommand $command): void
    {
        $this
            ->languageRepository
            ->remove(
                $this
                    ->languageRepository
                    ->findOrFail(
                        $command->getLocale()
                    )
            );
    }
}
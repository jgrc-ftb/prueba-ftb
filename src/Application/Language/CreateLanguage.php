<?php
namespace Application\Language;

use Domain\Model\Language;
use Domain\Model\LanguageRepository;

class CreateLanguage
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function handle(CreateLanguageCommand $command): Language
    {
        return $this
            ->languageRepository
            ->add(
                Language::create(
                    $command->getLocale(),
                    $command->getName()
                )
            );
    }
}
<?php
namespace AppBundle\Service;


use Application\Language\GetLanguages;
use Symfony\Component\HttpFoundation\RequestStack;

class GetUserLocale
{
    private $getLanguages;
    private $requestStack;

    public function __construct(GetLanguages $getLanguages, RequestStack $requestStack)
    {
        $this->getLanguages = $getLanguages;
        $this->requestStack = $requestStack;
    }

    public function handle()
    {
        return $this
            ->requestStack
            ->getCurrentRequest()
            ->getPreferredLanguage(
                array_map(
                    function($language) {
                        return $language->getId();
                    },
                    $this->getLanguages->ask()
                )
            );
    }
}
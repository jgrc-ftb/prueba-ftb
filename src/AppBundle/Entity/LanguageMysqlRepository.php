<?php
namespace AppBundle\Entity;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Domain\Model\LanguageExistsException;
use Domain\Model\LanguageNotFoundException;
use Domain\Model\LanguageRepository;
use Domain\Model\Language;

class LanguageMysqlRepository extends EntityRepository implements LanguageRepository
{
    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findOrFail(string $locale): Language
    {
        $language = parent::find($locale);

        if (null === $language) {
            throw new LanguageNotFoundException;
        }

        return $language;
    }

    public function add(Language $language): Language
    {
        try {
            $this
                ->getEntityManager()
                ->persist($language);

            $this
                ->getEntityManager()
                ->flush();

            return $language;
        } catch (UniqueConstraintViolationException $e) {
            throw new LanguageExistsException;
        }
    }

    public function remove(Language $language): void
    {
        $this
            ->getEntityManager()
            ->remove($language);

        $this
            ->getEntityManager()
            ->flush();
    }
}

<?php
namespace AppBundle\Entity;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Domain\Model\Club;
use Domain\Model\ClubNotFoundException;
use Domain\Model\ClubRepository;
use Domain\Model\ClubTranslation;
use Domain\Model\ClubTranslationExistsException;
use Domain\Model\Language;

class ClubMysqlRepository extends EntityRepository implements ClubRepository
{
    public function findOrFail(string $id): Club
    {
        $club = parent::find($id);

        if (null === $club) {
            throw new ClubNotFoundException;
        }

        return $club;
    }

    public function findClubTranslationOrFail(Club $club, Language $language): ClubTranslation
    {
        $clubTranslation = $this
            ->getEntityManager()
            ->getRepository('Domain\Model\ClubTranslation')
            ->find(
                [
                    'club' => $club,
                    'language' => $language
                ]
            );

        if (null === $clubTranslation) {
            throw new ClubNotFoundException;
        }

        return $clubTranslation;
    }

    public function findAll(): array
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('c, t')
            ->from('AppBundle:Club', 'c')
            ->leftJoin('c.clubTranslations', 't')
            ->getQuery()
            ->getResult();
    }

    public function findAllByLanguage(Language $language): array
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('c, t')
            ->from('Domain\Model\Club', 'c')
            ->innerJoin('c.clubTranslations', 't')
            ->where('t.language = :language')
            ->setParameter('language', $language)
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(
        Language $language,
        string $nameFilter,
        string $managerFilter
    ): array {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('c, t')
            ->from('Domain\Model\Club', 'c')
            ->innerJoin('c.clubTranslations', 't')
            ->where('t.language = :language')
            ->setParameter('language', $language);

        if (!empty($nameFilter)) {
            $query
                ->andWhere('c.name LIKE :nameFilter')
                ->setParameter('nameFilter', "%{$nameFilter}%");
        }

        if (!empty($managerFilter)) {
            $query
                ->andWhere('c.manager LIKE :managerFilter')
                ->setParameter('managerFilter', "%{$managerFilter}%");
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function add(Club $club): Club
    {
        $this
            ->getEntityManager()
            ->persist($club);

        $this
            ->getEntityManager()
            ->flush();

        return $club;
    }

    public function remove(Club $club): void
    {
        $this
            ->getEntityManager()
            ->remove($club);

        $this
            ->getEntityManager()
            ->flush();
    }

    public function addClubTranslation(ClubTranslation $clubTranslation): ClubTranslation
    {
        try {
            $this
                ->getEntityManager()
                ->persist($clubTranslation);

            $this
                ->getEntityManager()
                ->flush();

            return $clubTranslation;
        } catch (UniqueConstraintViolationException $e) {
            throw new ClubTranslationExistsException;
        }
    }

    public function removeClubTranslation(ClubTranslation $clubTranslation): void
    {
        $this
            ->getEntityManager()
            ->remove($clubTranslation);

        $this
            ->getEntityManager()
            ->flush();
    }
}

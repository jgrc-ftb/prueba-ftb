<?php
namespace Domain\Model;

interface ClubRepository
{
    public function findOrFail(string $id): Club;
    public function findClubTranslationOrFail(Club $club, Language $language): ClubTranslation;
    public function findAll(): array;
    public function findAllByLanguage(Language $language): array;
    public function findBySearch(Language $language, string $nameFilter, string $managerFilter): array;
    public function add(Club $club): Club;
    public function remove(Club $club): void;
    public function addClubTranslation(ClubTranslation $clubTranslation): ClubTranslation;
    public function removeClubTranslation(ClubTranslation $clubTranslation): void;
}

<?php
namespace Domain\Model;

interface LanguageRepository
{
    public function findAll(): array;
    public function findOrFail(string $locale): Language;
    public function add(Language $language): Language;
    public function remove(Language $language): void;
}

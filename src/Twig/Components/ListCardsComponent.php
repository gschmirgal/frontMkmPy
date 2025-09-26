<?php
// src/Twig/Components/ListCardsComponent.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('list_cards')]
class ListCardsComponent
{
    public array $data = [];
}

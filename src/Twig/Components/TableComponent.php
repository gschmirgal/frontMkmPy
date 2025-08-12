<?php
// src/Twig/Components/TableComponent.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

#[AsTwigComponent('table')]
class TableComponent
{
    public array $headers = [];
    public array $rows = [];
    public ?SlidingPagination $addPaginationRender = null;
}

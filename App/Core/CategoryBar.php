<?php

namespace App\Core;

/**
 * Class CategoryBar
 * @package App\Core
 */
class CategoryBar
{
    /**
     * Renders the Category bar in a recursive way.
     * This method uses the getAll method listed below to gather its first basic data.
     * @param array $categories
     */
    public static function render(array $categories): void
    {
        echo '<ul class="a-category-bar__list-item">';
        
        foreach ($categories as $category => $children) {
            echo '<li class="a-category-bar__list-item">';
                echo '<a class="a-category-bar__link">';
                    echo is_array($children) ? $category : $children;
                echo '</a>';
                is_array($children) ? self::render($children) : null;
            echo '</li>';
        }
        
        echo '</ul>';
    }
    
    /**
     * This method returns the associative array used to build the category bar.
     * @return string[] All Categories
     */
    public static function getAll(): array
    {
        // TODO: Replace data for data from database (CategoryController Thijmen)
        return [
            'Rubriek 1' => [
                'Rubriek 1 Child 1' => [
                    'Rubriek 1 Child Child 1',
                    'Rubriek 1 Child Child 2',
                    'Rubriek 1 Child Child 3',
                    'Rubriek 1 Child Child 4',
                ],
                'Rubriek 1 Child 2' => [
                    'Rubriek 2 Child Child 1',
                    'Rubriek 2 Child Child 2',
                    'Rubriek 2 Child Child 3',
                    'Rubriek 2 Child Child 4',
                ],
                'Rubriek 1 Child 3' => [
                    'Rubriek 3 Child Child 1',
                    'Rubriek 3 Child Child 2',
                    'Rubriek 3 Child Child 3',
                    'Rubriek 3 Child Child 4',
                ],
            ],
            'Rubriek 2' => [
                'Rubriek 2 Child 1' => [
                    'Rubriek 1 Child Child 1',
                    'Rubriek 1 Child Child 2',
                    'Rubriek 1 Child Child 3',
                    'Rubriek 1 Child Child 4',
                ],
                'Rubriek 2 Child 2' => [
                    'Rubriek 2 Child Child 1',
                    'Rubriek 2 Child Child 2',
                    'Rubriek 2 Child Child 3',
                    'Rubriek 2 Child Child 4',
                ],
                'Rubriek 2 Child 3' => [
                    'Rubriek 3 Child Child 1',
                    'Rubriek 3 Child Child 2',
                    'Rubriek 3 Child Child 3',
                    'Rubriek 3 Child Child 4',
                ],
            ],
            'Rubriek 3' => [
                'Rubriek 3 Child 1' => [
                    'Rubriek 1 Child Child 1',
                    'Rubriek 1 Child Child 2',
                    'Rubriek 1 Child Child 3',
                    'Rubriek 1 Child Child 4',
                ],
                'Rubriek 3 Child 2' => [
                    'Rubriek 2 Child Child 1',
                    'Rubriek 2 Child Child 2',
                    'Rubriek 2 Child Child 3',
                    'Rubriek 2 Child Child 4',
                ],
                'Rubriek 3 Child 3' => [
                    'Rubriek 3 Child Child 1',
                    'Rubriek 3 Child Child 2',
                    'Rubriek 3 Child Child 3',
                    'Rubriek 3 Child Child 4',
                ],
            ],
            'Rubriek 4' => [
                'Rubriek 1 Child' => [
                    'Rubriek 1 Child Child 1',
                    'Rubriek 1 Child Child 2',
                    'Rubriek 1 Child Child 3',
                    'Rubriek 1 Child Child 4',
                ],
                'Rubriek 2 Child' => [
                    'Rubriek 2 Child Child 1',
                    'Rubriek 2 Child Child 2',
                    'Rubriek 2 Child Child 3',
                    'Rubriek 2 Child Child 4',
                ],
                'Rubriek 3 Child' => [
                    'Rubriek 3 Child Child 1',
                    'Rubriek 3 Child Child 2',
                    'Rubriek 3 Child Child 3',
                    'Rubriek 3 Child Child 4',
                ],
            ],
        ];
    }
}
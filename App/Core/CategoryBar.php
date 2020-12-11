<?php

namespace App\Core;

use App\Controllers\CategoryController;
use App\Services\CategoryService;

/**
 * Class CategoryBar
 * @package App\Core
 */
class CategoryBar
{
    /**
     * @var CategoryService $categoryService    The category service which contains functions for categories
     */
    private $categoryService;

    /**
     * @var array   $categories     The list of categories to be used in the categorybar
     */
    private $categories = [];

    /**
     * The HTML markup.
     * @var
     */
    private $markup;

    /**
     * CategoryBar constructor.
     */
    public function __construct()
    {
        $this->categoryService = new CategoryService;
        $this->setCategories();
    }

    /**
     * Builds the Category Bar and echoes it.
     */
    public function render(): void
    {
        $this->build(true, array_slice($this->categories, 0, 4));
        echo $this->markup;
    }

    /**
     * Renders the Category bar in a recursive way.
     * @param bool  $all
     * @param array $categories
     */
    public function build(bool $all = false, array $categories = []): void
    {
        if ($all) {
            array_unshift($categories, ['name' => 'Alles', 'children' => $categories]);
        }

        $this->markup .= "<ul class='a-category-bar__list'>";

        foreach ($categories as $id => $category) {
            $this->markup .=
                "<li class='a-category-bar__list-item js-category-bar'>
                    <div>
                        <a href='/veilingen?categorieId=$id' class='a-category-bar__link'>
                            {$category['name']}
                        </a>";

            if (!empty($category['children'])) {
                if ($all) {
                    $this->markup .= "<i class='fas fa-chevron-down a-category-bar__icon'></i>";
                } else {
                    $this->markup .= "<i class='fas fa-chevron-right a-category-bar__icon'></i>";
                }
            }

            $this->markup .= "</div>";

            if (!empty($category['children'])) {
                $this->build(false, $category['children']);
            }

            $this->markup .= "</li>";
        }

        $this->markup .= "</ul>";
    }

    /**
     * This method regulates the creation of the categories based on
     * the index method of the category controller.
     * @return void
     */
    public function setCategories(): void
    {
        $cc = new CategoryController;
        $leveledCategories = $this->categoryService->sortPerLevel($cc->index());
        $this->categories = $this->categoryService->sortAssociatively($leveledCategories);
    }
}

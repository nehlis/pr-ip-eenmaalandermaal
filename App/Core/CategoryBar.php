<?php

namespace App\Core;

use App\Controllers\CategoryController;

/**
 * Class CategoryBar
 * @package App\Core
 */
class CategoryBar
{
    /**
     * The formatted categories to display in the menu.
     * @var
     */
    private $categories = [0 => [], 1 => [], 2 => [], 3 => [], 4 => []];
    
    /**
     * CategoryBar constructor.
     */
    public function __construct()
    {
        $this->setCategories();
    }
    
    /**
     * Renders the Category bar in a recursive way.
     * This method uses the getAll method listed below to gather its first basic data.
     * @param array $categories
     */
    public function render(array $categories = []): void
    {
        if (empty($categories)) {
            $categories = $this->categories;
        }
        
        echo "<ul class='a-category-bar__list'>";
        
        foreach ($categories as $id => $category) {
            echo "<li class='a-category-bar__list-item'>";
            echo "<a href='/veilingen?categorieId=$id' class='a-category-bar__link'>{$category['name']}</a>";
            
            if (!empty($category['children'])) {
                self::render($category['children']);
            }
            
            echo "</li>";
        }
        
        echo "</ul>";
    }
    
    /**
     * This method regulates the creation of the categories based on
     * the index method of the category controller.
     * @return void All Categories
     */
    public function setCategories(): void
    {
        $cc = new CategoryController;
        
        $this->categories = $this
            ->sortPerLevel($cc->index())
            ->sortAccociatively();
    }
    
    /**
     * Formats the queried data per level and removes the duplicates
     * @param $columns
     * @return CategoryBar
     */
    private function sortPerLevel($columns): CategoryBar
    {
        foreach ($columns as $column) {
            // Here we build our own array, this because this way we can
            // differentiate each level without having to check for key value.
            $levels = [
                [$column['Level1ID'], $column['Level1Name']],
                [$column['Level2ID'], $column['Level2Name']],
                [$column['Level3ID'], $column['Level3Name']],
                [$column['Level4ID'], $column['Level4Name']],
                [$column['Level5ID'], $column['Level5Name']],
            ];
            
            foreach ($levels as $index => $level) {
                [$id, $name] = $level;
                
                if (is_null($id)) {
                    continue;
                }
                
                // If the Level does not exists, add it and initialize the children array.
                if (!array_key_exists($id, $this->categories[$index])) {
                    $this->categories[$index][$id] = ['name' => $name, 'children' => []];
                }
                
                [$childId, $childName] = $levels[$index + 1];
                
                // If the child is already initialized or empty, don't add it again.
                if (array_key_exists($childId, $this->categories[$index][$id]['children']) || is_null($childId)) {
                    continue;
                }
                
                // Here we add the children (if found) to the children property.
                $this->categories[$index][$id]['children'][$childId] = ['name' => $childName, 'children' => []];
            }
        }
        
        return $this;
    }
    
    /**
     * Formats all the inputted array from by-level to an associative array.
     * @return array
     */
    private function sortAccociatively(): array
    {
        // Unset levels if fully empty. We do this because otherwise
        // the count in the for loop won't output the desired amount.
        foreach ($this->categories as $id => $level) {
            if (empty($level)) {
                unset($this->categories[$id]);
            }
        }
        
        // Loop through the levels, start at the second last index, stop with the first.
        for ($i = count($this->categories) - 2; $i >= 0; $i--) {
            foreach ($this->categories[$i] as $itemId => $item) {
                foreach ($item['children'] as $childId => $child) {
                    // If child ID is set, copy it to this iteration in array.
                    if (isset($this->categories[$i + 1][$childId])) {
                        $this->categories[$i][$itemId]['children'][$childId] = $this->categories[$i + 1][$childId];
                    }
                }
            }
        }
        
        // After deprecating each value to the parent, the first index will
        // include all of it's children, so we only return this value.
        return $this->categories[0];
    }
}

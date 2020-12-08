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
     * The formatted categories to display in the menu. Starts by level.
     * @var
     */
    private $categories = [
        0 => [],
        1 => [],
        2 => [],
        3 => [],
        4 => [],
    ];
    
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

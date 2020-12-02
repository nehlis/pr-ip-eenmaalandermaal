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
     * @var
     */
    private $categories = [];
    
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
            $keys = array_keys($this->categories[0]);
            
            $categories = [
                $this->categories[0][$keys[0]],
                $this->categories[0][$keys[1]],
                $this->categories[0][$keys[2]],
                $this->categories[0][$keys[3]],
                $this->categories[0][$keys[4]],
                $this->categories[0][$keys[5]],
            ];
        }
        
        echo "<ul class='a-category-bar__list'>";
        
        foreach ($categories as $id => $category) {
            echo "<li class='a-category-bar__list-item'>";
            echo "<a href='/veilingen?categorie=$id' class='a-category-bar__link'>";
            echo $category['name'];
            echo "</a>";
            
            if (!empty($category['children'])) {
                self::render($category['children']);
            }
            
            echo "</li>";
        }
        
        echo "</ul>";
    }
    
    /**
     * This method returns the associative array used to build the category bar.
     * @return void All Categories
     */
    public function setCategories(): void
    {
        $cc = new CategoryController;
        
        $this->formatCategories($cc->index());
    }
    
    /**
     * @param array $columns
     * @return void
     */
    public function formatCategories(array $columns): void
    {
        $temp = [0 => [], 1 => [], 2 => [], 3 => [], 4 => []];
        
        $temp = $this->formatPerLevel($columns, $temp);
        $temp = $this->formatAssociative($temp);
        
        $this->categories = $temp;
    }
    
    /**
     * @param $columns
     * @param $new
     * @return array
     */
    private function formatPerLevel($columns, $new): array
    {
        foreach ($columns as $column) {
            $levels = [
                [$column['Level1ID'], $column['Level1Name']],
                [$column['Level2ID'], $column['Level2Name']],
                [$column['Level3ID'], $column['Level3Name']],
                [$column['Level4ID'], $column['Level4Name']],
                [$column['Level5ID'], $column['Level5Name']],
            ];
            
            foreach ($levels as $index => $level) {
                [$id, $name] = $level;
                
                // Skip if is null.
                if (is_null($id) || is_null($name)) {
                    continue;
                }
                
                // If the Level does not exists, add it and initialize the children array.
                if (!array_key_exists($id, $new[$index])) {
                    $new[$index][$id] = [
                        'name'     => $name,
                        'children' => [],
                    ];
                }
                
                // While there are children, add them to the children key.
                for ($i = 1; isset($levels[$index + $i][0]); $i++) {
                    [$childId, $childName] = $levels[$index + $i];
                    
                    if (!array_key_exists($childId, $new[$index][$id]['children'])) {
                        $new[$index][$id]['children'][$childId] = [
                            'name'     => $childName,
                            'children' => [],
                        ];
                    }
                }
            }
        }
        
        return $new;
    }
    
    /**
     * @param array $levels
     * @return array
     */
    private function formatAssociative(array $levels): array
    {
        foreach ($levels as $depth => $level) {
            // 0 => 1 => 2 => 3 => 4
            foreach ($level as $itemId => $item) {
                // 1 => ['name' => 'Verzamelen', 'children' => [...]
                foreach ($item['children'] as $childId => $child) {
                    // 32 => Poppen
                    if (isset($levels[$depth + 1][$childId])) {
                        $levels[$depth][$itemId]['children'][$childId] = $levels[$depth + 1][$childId];
                    }
                }
            }
        }
        
        return $levels;
    }
}
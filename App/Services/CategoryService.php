<?php

namespace App\Services;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService
{
    /**
     * The associated formatted categories to display in the menu. Starts by level.
     * @var
     */
    private static $categories = [
        0 => [],
        1 => [],
        2 => [],
        3 => [],
        4 => [],
    ];

    /**
     * Formats the queried data per level and removes the duplicates
     * @param $columns  An array of all unsorted categories
     * @return array    An array of leveled categories
     */
    public function sortPerLevel(array $columns): array
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
                if (!array_key_exists($id, self::$categories[$index])) {
                    self::$categories[$index][$id] = ['name' => $name, 'children' => []];
                }

                [$childId, $childName] = $levels[$index + 1];

                // If the child is already initialized or empty, don't add it again.
                if (array_key_exists($childId, self::$categories[$index][$id]['children']) || is_null($childId)) {
                    continue;
                }

                // Here we add the children (if found) to the children property.
                self::$categories[$index][$id]['children'][$childId] = ['name' => $childName, 'children' => []];
            }
        }

        return self::$categories;
    }


    /**
     * Formats all the inputted array from by-level to an associative array.
     * @param  array    $categories  An array of all leveled categories
     * @return array    An array of sorted categories
     */
    public function sortAssociatively(array $categories): array
    {
        // Unset levels if fully empty. We do this because otherwise
        // the count in the for loop won't output the desired amount.
        foreach ($categories as $id => $level) {
            if (empty($level)) {
                unset($categories[$id]);
            }
        }

        // Loop through the levels, start at the second last index, stop with the first.
        for ($i = count($categories) - 2; $i >= 0; $i--) {
            foreach ($categories[$i] as $itemId => $item) {
                foreach ($item['children'] as $childId => $child) {
                    // If child ID is set, copy it to this iteration in array.
                    if (isset($categories[$i + 1][$childId])) {
                        $categories[$i][$itemId]['children'][$childId] = $categories[$i + 1][$childId];
                    }
                }
            }
        }

        // After deprecating each value to the parent, the first index will
        // include all of it's children, so we only return this value.
        self::$categories = $categories[0];
        return self::$categories;
    }

    /**
     * Gets category array
     * @return  array   Sorted category array
     */
    public function getCategories(): array
    {
        return self::$categories;
    }


    /**
     * Gets the children from the category
     * @return  array|null  The child element
     */
    public static function hasChildren(array $category): bool
    {
        return count($category['children']) > 0;
    }
}

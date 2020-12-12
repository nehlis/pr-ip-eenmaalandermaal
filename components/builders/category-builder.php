<?php

namespace Components\Builders;

class CategoryBuilder
{

    /**
     * Builds Category Compress Component
     * @var     int             $id         The id of the category
     * @var     string          $name       The name of the category
     * @var     mixed           $children   The content of the card
     * @return  string|null                 The category collapse component, none if invalid
     */
    public static function buildCategoryCollapsable(int $id, string $name, $children): ?string
    {
        if (empty($children)) {
            return null;
        }
        return "
        <div class=\"card\">
            <div class=\"card-header\" id=\"headingC$id\">
                <h2 class=\"mb-0\">
                    <button class=\"btn btn-link btn-block text-left\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseCategory$id\" aria-controls=\"collapseCategory$id\">
                        $name
                    </button>
                </h2>
            </div>
                
            <div id=\"collapseCategory$id\" class=\"collapse\" aria-labelledby=\"headingC$id\" data-parent=\"#categoryCollapse\">
                <div class=\"card-body\">
                    $children
                </div>
            </div>
        </div>
        ";
    }

    /**
     * Builds Category List Component
     * @var     int     $id     The id of the category
     * @var     string  $name   The name of the category
     * @return  string          The category list component
     */
    public static function buildCategoryList(array $categories): ?string
    {
        $element = "<ul>";
        foreach ($categories as $id => $name) {
            $element .= "<li>" . utf8_decode($name) . "</li>";
        }
        return $element .= "</ul>";
    }
}

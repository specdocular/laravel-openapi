<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Document as DocumentAttribute;

/**
 * Determines if a route belongs to a specific OpenAPI document.
 *
 * Handles the logic for matching routes to documents based on
 * controller and action-level Document attributes.
 */
final readonly class DocumentMatcher
{
    public function __construct(
        private RouteInfo $routeInfo,
    ) {
    }

    /**
     * Check if the route belongs to the specified document.
     *
     * When the action has a Document attribute and config
     * 'openapi.document.action_attribute_overrides_controller_attribute' is true (default),
     * only the action's document is checked. Otherwise, both are checked.
     */
    public function isInDocument(string $document): bool
    {
        $actionDocumentAttr = $this->getActionDocumentAttribute();
        if (
            !is_null($actionDocumentAttr)
            && config()->boolean('openapi.document.action_attribute_overrides_controller_attribute', true)
        ) {
            return in_array(
                $document,
                $actionDocumentAttr->name,
                true,
            );
        }

        return in_array(
            $document,
            $this->getControllerDocumentAttribute()?->name ?? [],
            true,
        ) || in_array(
            $document,
            $actionDocumentAttr?->name ?? [],
            true,
        );
    }

    /**
     * Check if the route has any Document attribute.
     */
    public function hasDocumentAttribute(): bool
    {
        return $this->getDocumentAttributes()->isNotEmpty();
    }

    /**
     * Get all Document attributes from both controller and action.
     */
    public function getDocumentAttributes(): Collection
    {
        return $this->routeInfo->controllerAttributes()
            ->merge($this->routeInfo->actionAttributes())
            ->filter(
                static function (object $attribute): bool {
                    return $attribute instanceof DocumentAttribute;
                },
            );
    }

    private function getControllerDocumentAttribute(): DocumentAttribute|null
    {
        return $this->routeInfo->controllerAttributes()
            ->first(
                static function (object $attribute): bool {
                    return $attribute instanceof DocumentAttribute;
                },
            );
    }

    private function getActionDocumentAttribute(): DocumentAttribute|null
    {
        return $this->routeInfo->actionAttributes()
            ->first(
                static function (object $attribute): bool {
                    return $attribute instanceof DocumentAttribute;
                },
            );
    }
}

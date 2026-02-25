<?php

namespace Specdocular\LaravelOpenAPI\Support;

use Illuminate\Support\Collection;
use Specdocular\LaravelOpenAPI\Attributes\Scope as ScopeAttribute;

/**
 * Determines if a route belongs to a specific OpenAPI scope.
 *
 * Handles the logic for matching routes to scopes based on
 * controller and action-level Scope attributes.
 */
final readonly class ScopeMatcher
{
    public function __construct(
        private RouteInfo $routeInfo,
    ) {
    }

    /**
     * Check if the route belongs to the specified scope.
     *
     * When the action has a Scope attribute and config
     * 'openapi.scope.action_attribute_overrides_controller_attribute' is true (default),
     * only the action's scope is checked. Otherwise, both are checked.
     */
    public function isInScope(string $scope): bool
    {
        $actionScopeAttr = $this->getActionScopeAttribute();
        if (
            !is_null($actionScopeAttr)
            && config()->boolean('openapi.scope.action_attribute_overrides_controller_attribute', true)
        ) {
            return in_array(
                $scope,
                $actionScopeAttr->name,
                true,
            );
        }

        return in_array(
            $scope,
            $this->getControllerScopeAttribute()?->name ?? [],
            true,
        ) || in_array(
            $scope,
            $actionScopeAttr?->name ?? [],
            true,
        );
    }

    /**
     * Check if the route has any Scope attribute.
     */
    public function hasScopeAttribute(): bool
    {
        return $this->getScopeAttributes()->isNotEmpty();
    }

    /**
     * Get all Scope attributes from both controller and action.
     */
    public function getScopeAttributes(): Collection
    {
        return $this->routeInfo->controllerAttributes()
            ->merge($this->routeInfo->actionAttributes())
            ->filter(
                static function (object $attribute): bool {
                    return $attribute instanceof ScopeAttribute;
                },
            );
    }

    private function getControllerScopeAttribute(): ScopeAttribute|null
    {
        return $this->routeInfo->controllerAttributes()
            ->first(
                static function (object $attribute): bool {
                    return $attribute instanceof ScopeAttribute;
                },
            );
    }

    private function getActionScopeAttribute(): ScopeAttribute|null
    {
        return $this->routeInfo->actionAttributes()
            ->first(
                static function (object $attribute): bool {
                    return $attribute instanceof ScopeAttribute;
                },
            );
    }
}

<?php

namespace App\Filament\Resources\RecipeResource\Widgets;

use App\Filament\Resources\RecipeResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Recipes', RecipeResource::getEloquentQuery()->count())
        ];
    }
}

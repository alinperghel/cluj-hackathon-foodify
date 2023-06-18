<?php

namespace App\Filament\Resources\RecipeResource\Pages;

use App\Filament\Resources\RecipeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipes extends ListRecords
{
    protected static string $resource = RecipeResource::class;
    protected static ?string $pollingInterval = '5s';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

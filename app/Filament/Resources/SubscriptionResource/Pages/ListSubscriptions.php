<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    public function boot()
    {
        Filament::registerScripts([
            'square' => 'https://sandbox.web.squarecdn.com/v1/square.js',
            'square-app' => asset('assets/js/square-app.js'),
        ]);
        Filament::registerStyles(['square-css' => asset('assets/css/square-app.css')]);
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

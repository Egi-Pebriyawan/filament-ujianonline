<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TryoutOnline extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tryout-online';

    //membuat parsing code disini untuk menangkap package id
    public $packageId;
    //membuat tryoutonline hilang dari dashboard admin
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    //mount fungsi untuk dirender ditampilan 
    public function mount($packageId)
    {
        $this->packageId = $packageId;
    }
    

}

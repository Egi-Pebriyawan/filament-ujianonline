<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TryoutResource\Pages;
use App\Filament\Resources\TryoutResource\RelationManagers;
use App\Models\Tryout;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Auth;

class TryoutResource extends Resource
{
    protected static ?string $model = Tryout::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-right-start-on-rectangle';
// Menambahakn nomer urut untuk tampilan menu
protected static ?int $navigationSort =3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('package_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('started_at'),
                Forms\Components\DateTimePicker::make('finished_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        // Membuat agar yang bisa melihat hanya super admin saja
        ->modifyQueryUsing(function (Builder $query)
        {$is_super_admin = Auth::user()->hasRole('super_admin');
            if ( !$is_super_admin){
                $query->where('user_id', Auth::user()->id);
            }
        })
        //Akhir codingan untuk superadmin
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Berakhir')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->getStateUsing(function($record) {
                        return $record->tryOutAnswers->sum('score');
                    })
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
          
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTryouts::route('/'),
            'create' => Pages\CreateTryout::route('/create'),
            'edit' => Pages\EditTryout::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Doctrine\DBAL\Schema\Table as SchemaTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;
use Carbon\Carbon;
use Tables\Actions\Action;
use Auth;




class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   // Menambahakn nomer urut untuk tampilan menu
    protected static ?int $navigationSort =2;
    public static function form(Form $form): Form
    {
        // Tampilan di UI untuk packages
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('duration')
                                ->label('Durasi (dalam menit)')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('start_datetime')
                                ->label('Tanggal dan Jam Mulai')
                                ->required()
                                ->type('datetime-local')
                                ->helperText('Format: yyyy-mm-ddThh:mm'),
                            Forms\Components\TextInput::make('end_datetime')
                                ->label('Tanggal dan Jam Selesai')
                                ->required()
                                ->type('datetime-local')
                                ->helperText('Format: yyyy-mm-ddThh:mm'),
                        ])
                ]),
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Repeater::make('questions')
                                ->relationship('questions')
                                ->schema([
                                    Forms\Components\Select::make('question_id')
                                        ->allowHtml()
                                        ->relationship('question', 'question')
                                        ->label('Soal')
                                        ->required()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                ])
                        ])
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
    ->columns([
        Tables\Columns\TextColumn::make('name')
            ->searchable(),
        Tables\Columns\TextColumn::make('duration')
            ->label('Durasi (dalam menit)')
            ->numeric()
            ->sortable(),
        Tables\Columns\TextColumn::make('questions_count')
            ->counts('questions')
            ->label('Jumlah Soal')
            ->numeric()
            ->sortable(),
        Tables\Columns\TextColumn::make('start_datetime')
            ->label('Tanggal & Jam Mulai')
            ->sortable()
            ->dateTime(), // Format untuk tanggal dan jam mulai
        Tables\Columns\TextColumn::make('end_datetime')
            ->label('Tanggal & Jam Selesai')
            ->sortable()
            ->dateTime(), // Format untuk tanggal dan jam selesai
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
    ->filters([
        //
    ])
    ->actions([
        Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Kerjakan')
                    ->url(fn (Package $record): string => route('do-tryout', $record))
                    ->color('success')
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn (Package $record) => 
                        Auth::user()->hasRole('super_admin') || 
                        (
                            
                          Carbon::now('Asia/Jakarta'))->between($record->start_datetime, $record->end_datetime) && 
                            Auth::user()->hasRole('siswa')
                            //  &&
                            // !$record->users()->where('user_id', Auth::id())->exists()
                        )
                    
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

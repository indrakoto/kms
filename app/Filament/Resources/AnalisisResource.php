<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnalisisResource\Pages;
use App\Filament\Resources\AnalisisResource\RelationManagers;
use App\Models\Analisis;
use App\Models\Institusi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class AnalisisResource extends Resource
{
    protected static ?string $model = Analisis::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel   = 'Nama Analisis';
    protected static ?string $navigationGroup = 'Analisis';

    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Hapus Data')
                    ->modalDescription('Apakah anda sudah yakin untuk menghapus ini ?')
                    ->modalSubmitActionLabel('Ya')
                    ->modalCancelActionLabel('Batal'),
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
            'index' => Pages\ListAnalises::route('/'),
            //'create' => Pages\CreateAnalisis::route('/create'),
            'view' => Pages\ViewAnalisis::route('/{record}'),
            //'edit' => Pages\EditAnalisis::route('/{record}/edit'),
        ];
    }
}

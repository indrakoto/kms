<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NeracaResource\Pages;
use App\Filament\Resources\NeracaResource\RelationManagers;
use App\Models\Analisis;
use App\Models\Neraca;
use App\Models\Institusi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class NeracaResource extends Resource
{
    protected static ?string $model = Neraca::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationLabel   = 'Data Analisis ';
    //protected static ?string $navigationGroup   = 'Master Data';
    protected static ?string $navigationGroup = 'Analisis';

    protected static ?int $navigationSort = 4;
    protected static bool $shouldRegisterNavigation = false;

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
                
                Select::make('analisis_id')->label('Analisis')
                    ->options(Analisis::orderBy('id', 'asc')->pluck('name','id'))
                    ->required(),
                Select::make('institusi_id')->label('Institusi')
                    ->options(Institusi::orderBy('id', 'asc')->pluck('name','id'))
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('analisis.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('institusi.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                //Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNeracas::route('/'),
            //'create' => Pages\CreateNeraca::route('/create'),
            //'edit' => Pages\EditNeraca::route('/{record}/edit'),
            'view' => Pages\ViewNeraca::route('/{record}'),
        ];
    }
}

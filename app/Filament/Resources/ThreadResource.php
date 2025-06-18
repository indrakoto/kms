<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThreadResource\Pages;
use App\Models\Thread;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ThreadResource\RelationManagers\RepliesRelationManager;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Components\Format;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;

class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    // Define the name and icon for the resource
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel   = 'Thread';

    protected static ?string $navigationGroup = 'Forums';
    protected static ?int $navigationSort = 5;


    public static function shouldRegisterNavigation(): bool
    {
        //dd(auth()->user()->institusi_id);
        //return auth()->check(); // semua user login bisa lihat
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->institusi_id !== null);
    }

    // Customize the label for this resource

    // Define the form for creating/editing the resource
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('content')
                            ->label('Content') // Label untuk editor
                            ->required(),
                        Hidden::make('user_id')
                            ->default(auth()->id()) // Menetapkan ID user yang sedang login
                            ->required()
                ])

            ]);
    }

    // Define the table for listing the resource
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                // Add any filters you'd like here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    // Define relations managers for related resources
    public static function relationManagers(): array
    {
        return [
            RepliesRelationManager::class,
        ];
    }

    // Define pages (for example, List, Create, Edit)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThreads::route('/'),
            'create' => Pages\CreateThread::route('/create'),
            'edit' => Pages\EditThread::route('/{record}/edit'),
            //'view' => Pages\ViewThread::route('/{record}'),
        ];
    }
}

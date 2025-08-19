<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BasisdataAlphabyteResource\Pages;
use App\Filament\Resources\BasisdataAlphabyteResource\RelationManagers;
use App\Models\BasisdataAlphabyte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class BasisdataAlphabyteResource extends Resource
{
    protected static ?string $model = BasisdataAlphabyte::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel   = 'Basis Data Alphabyte';
    protected static ?string $recordTitleAttribute  = 'Sumber data latih Alphabyte';
    //protected static ?string $navigationGroup = 'Knowledge';
    protected static ?int $navigationSort = 6;
    //protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tambah Data')
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        RichEditor::make('content')
                            ->columnSpanFull(),

                        FileUpload::make('file_path')
                            ->label('PDF File')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->disk('alphabyte_data') // gunakan disk private,
    
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->limit(80)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_processed')->label('Status')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('process')
                    ->label('Process')
                    ->icon('heroicon-o-cloud')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function (BasisdataAlphabyte $record) {
                        // Kirim POST request ke API proses
                        $response = Http::post(route('alphabyte.process', ['id' => $record->id]));

                        //dd( $response->body());

                        if ($response->successful()) {
                            $record->is_processed = 1;
                            $record->save();

                            Notification::make()
                                ->title($response->body())
                                ->body($response->body())
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal menjalankan proses API')
                                ->body($response->body())
                                ->danger()
                                ->send();
                        }
                    }),


                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBasisdataAlphabytes::route('/'),
            'create' => Pages\CreateBasisdataAlphabyte::route('/create'),
            'edit' => Pages\EditBasisdataAlphabyte::route('/{record}/edit'),
        ];
    }
}

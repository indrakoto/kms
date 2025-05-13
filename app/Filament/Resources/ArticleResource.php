<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use App\Models\Category;
use App\Models\ExpertProfile;
use App\Models\Institusi;
use App\Models\Source;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel   = 'Artikel/Pengetahuan/Video';
    protected static ?string $recordTitleAttribute  = 'Pengetahuan,Video,Link Website';
    protected static ?string $navigationGroup = 'Knowledge';
    
    protected static bool $shouldRegisterNavigation = true;
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tambah Konten')
                    ->schema([

                        Select::make('source_id')
                            ->label('Tipe Konten')
                            ->options(Source::orderBy('id', 'asc')->pluck('name','id'))
                            //->relationship('source', 'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Reset fields ketika type berubah
                                $set('file_path', null);
                                $set('video_path', null);
                                $set('embed_code', null);
                            }),
                    
                        Select::make('category_id')
                            ->label('Kategori')
                            //->relationship('category', 'name')
                            ->options(Category::orderBy('id', 'asc')->pluck('name','id'))
                            ->required(),

                        Select::make('institusi_id')
                            ->label('Institusi')
                            //->relationship('institusi', 'name')
                            ->options(Institusi::orderBy('id', 'asc')->pluck('name','id'))
                            ->required(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug'),
                        
                        RichEditor::make('content')
                            ->columnSpanFull()
                            ->visible(function (Forms\Get $get) {
                                //$sourceName = Source::find($get('source_id'))?->name;
                                //return in_array($sourceName, ['text']);
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return $sourceName === 'text';
                            }),


                        FileUpload::make('file_path')
                            ->label('PDF File')
                            ->acceptedFileTypes(['application/pdf'])
                            //->directory('articles/pdf')
                            ->required(function (Forms\Get $get): bool {
                                $source = Source::find($get('source_id'));
                                return $source && strtolower($source->name) === 'pdf';
                            })
                            ->visible(function (Forms\Get $get): bool {
                                $source = Source::find($get('source_id'));
                                return $source && strtolower($source->name) === 'pdf';
                            }),

                        FileUpload::make('video_path')
                            ->label('Video File')
                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                            //->directory('articles/videos')
                            ->visible(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return $sourceName === 'video';
                            }),

                        Textarea::make('embed_code')
                            ->label('Embed Code')
                            ->placeholder('<iframe src="..." width="600" height="400"></iframe>')
                            ->helperText(function (Forms\Get $get) {
                                //$sourceName = Source::find($get('source_id'))?->name;
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return $sourceName === 'youtube' 
                                    ? 'Paste YouTube embed code' 
                                    : 'Paste full iframe code';
                            })
                            ->visible(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return in_array($sourceName, ['youtube', 'link']);
                            }),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('') // kosongkan karena kita sudah atur root-nya ke public/articles/thumbnails
                            ->disk('thumbnails_public'),

                        Toggle::make('is_published')
                            ->required(),

                        Select::make('user_id')->label('Tutor/Instruktur/Admin')
                            ->options(ExpertProfile::orderBy('id', 'asc')->pluck('expertise','id'))
                            ->required(),
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('source.name')
                    ->badge()
                    ->color(function ($record) {
                        return match ($record->source->name) {
                            'text' => 'info',
                            'pdf' => 'danger',
                            'video', 'youtube' => 'primary',
                            'link' => 'success',
                            default => 'gray',
                        };
                    }),
                Tables\Columns\TextColumn::make('views')
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
            'index' => Pages\ListArticles::route('/'),
            //'create' => Pages\CreateArticle::route('/create'),
            //'edit' => Pages\EditArticle::route('/{record}/edit'),
            'view' => Pages\ViewArticle::route('/{record}'),
        ];
    }
}

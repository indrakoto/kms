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
use Michaeld555\FilamentCroppie\Components\Croppie;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Notifications\Notification;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel   = 'Konten';
    protected static ?string $recordTitleAttribute  = 'Analisis, Knowledge, Layanan Publik, Artikel, Video, Link Website';
    //protected static ?string $navigationGroup = 'Knowledge';
    protected static ?int $navigationSort = 6;
    //protected static bool $shouldRegisterNavigation = true;
    public static function shouldRegisterNavigation(): bool
    {
        //dd(auth()->user()->institusi_id);
        //return auth()->check(); // semua user login bisa lihat
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->institusi_id !== null);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tambah Konten')
                    ->schema([

                        SelectTree::make('institusi_id')
                                ->label('Institusi')
                                ->withCount()
                                ->relationship('institusi', 'name', 'parent')
                                ->required(),
                                
                        Select::make('category_id')
                            ->label('Kategori')
                            //->relationship('category', 'name')
                            ->options(Category::orderBy('id', 'asc')->pluck('name','id'))
                            ->required(),

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
                                $set('embed_link', null);
                            }),
                                
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
                                    ? 'Paste YouTube/Facebook/Instagram embed code' 
                                    : 'Paste full iframe code';
                            })
                            ->visible(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return in_array($sourceName, ['youtube','tableau']);
                            }),
                            
                        Textarea::make('embed_link')
                            ->label('Embed Link')
                            ->placeholder('http or https://...')
                            ->helperText(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return $sourceName === 'link' 
                                    ? 'Paste full link with http or https' 
                                    : 'Paste full link with http or https';
                            })
                            ->visible(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return in_array($sourceName, ['link']);
                            }),

                        Toggle::make('redirect_link')
                            ->label('Direct langsung ke link ?')
                            ->onColor('success') // Hijau saat ON
                            ->onIcon('heroicon-o-check')  // Icon saat ON
                            ->offIcon('heroicon-o-x-mark') // Icon saat OFF
                            ->required()
                            ->visible(function (Forms\Get $get) {
                                $sourceName = strtolower(Source::find($get('source_id'))?->name);
                                return in_array($sourceName, ['link']);
                            }),
                        //FileUpload::make('thumbnail')
                        //    ->image()
                        //    ->directory('') // kosongkan karena kita sudah atur root-nya ke public/articles/thumbnails
                        //    ->disk('thumbnails_public'),

                        Croppie::make('thumbnail')
                            ->disk('thumbnails_public')
                            ->viewportType('square')
                            ->viewportHeight(412)
                            ->viewportWidth(704)
                            ->boundaryHeight(500)
                            ->boundaryWidth(800)
                            ->enableZoom(true)
                            ->imageFormat('png')
                            ->imageName('thumb_'),
                            
                        Toggle::make('is_published')
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
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('source.name')
                    ->label('Tipe')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(function ($record) {
                        return match ($record->source->name) {
                            'text' => 'info',
                            'pdf' => 'danger',
                            'video', 'youtube' => 'primary',
                            'link' => 'success',
                            default => 'gray',
                        };
                    }),                    

                ToggleColumn::make('is_published')
                    ->label('Published')
                    ->sortable()
                    ->toggleable() // ini memungkinkan toggle aktif/nonaktif
                    ->onColor('success') // Warna hijau saat aktif
                    ->offColor('danger') // Warna merah saat non-aktif
                    ->afterStateUpdated(function ($record, $state) {
                        // Optional: Notifikasi setelah update
                        Notification::make()
                            ->title('Status updated')
                            ->success()
                            ->send();
                    })
                    ->disabled(fn ($record) => !(
                        auth()->user()?->isAdmin() ||
                        auth()->user()?->institusi_id === $record->institusi_id
                    )),

                /*Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                */

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // <-- Urutkan dari terbaru
            ->filters([
                    SelectFilter::make('category_id')
                        ->label('Filter by Category')
                        //->options(Category::pluck('name', 'id'))
                        ->relationship('category', 'name') // ini penting untuk relasi
                        ->searchable() // Opsional: bisa dicari
                        ->preload(), // Opsional: load data awal

                    SelectFilter::make('source_id')
                        ->label('Filter by Tipe Konten')
                        //->options(Category::pluck('name', 'id'))
                        ->relationship('source', 'name') // ini penting untuk relasi
                        ->searchable() // Opsional: bisa dicari
                        ->preload() // Opsional: load data awal
                ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => auth()->user()->isAdmin() || auth()->user()->institusi_id === $record->institusi_id),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => auth()->user()->isAdmin() || auth()->user()->institusi_id === $record->institusi_id)
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
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
            //'view' => Pages\ViewArticle::route('/{record}'),
        ];
    }

// app/Filament/Resources/ArtikelResource.php

    public static function canCreate(): bool
    {
        return auth()->user()->can('create', Article::class);
    }

    public static function canViewAny(): bool
    {
        return true; // Semua bisa lihat
    }

}

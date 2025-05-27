<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstitusiResource\Pages;
use App\Filament\Resources\InstitusiResource\RelationManagers;
use App\Models\Institusi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InstitusiResource extends Resource
{
    protected static ?string $model = Institusi::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel   = 'Institusi ';
    protected static ?string $navigationGroup   = 'Master';
    protected static ?int $navigationSort = 1;
    //protected static bool $shouldRegisterNavigation = true;
    public static function shouldRegisterNavigation(): bool
    {
        //dd(auth()->user()->institusi_id);
        //return auth()->check(); // semua user login bisa lihat
        $user = auth()->user();
        return $user && $user->isAdmin();
    }

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
                
                // Select Parent Division (gunakan kolom 'parent')
                Forms\Components\Select::make('parent')
                    ->label('Parent Institusi')
                    ->options(function (?Institusi $record) {
                        $query = Institusi::query()
                            ->whereNull('parent'); // Hanya tampilkan Institusi utama

                        if ($record) {
                            $query->where('id', '!=', $record->id); // Hindari memilih diri sendiri
                        }

                        return $query->pluck('name', 'id');
                    })
                    ->nullable()
                    ->searchable(),

                // Section untuk Child Divisions
                Forms\Components\Section::make('')
                    ->schema([
                        Repeater::make('children')
                            ->label('Sub Institusi')
                            ->relationship()
                            ->schema([
                                Section::make([
                                    Forms\Components\TextInput::make('name')
                                        ->required(),
                                    Forms\Components\TextInput::make('slug')
                                        ->required()
                                ])
                                ->columns(1)
                                ->extraAttributes(function (array $state, mixed $component): array {
                                    // Daftar warna pastel
                                    $colors = ['#FFD1DC', '#D1FFD7', '#D1E3FF', '#E6D1FF'];
                                    
                                    // Dapatkan index item secara manual
                                    $path = $component->getContainer()->getStatePath();
                                    $index = (int) substr(strrchr($path, '.'), 1);
                                    $hash = crc32($state['name'] ?? 'default');
                                    $hue = $hash % 360;
                                    return [
                                        /*'style' => "background: {$colors[$index % count($colors)]}; 
                                                   border-radius: 8px; 
                                                   padding: 12px;"*/
                                        'style' => "background: hsl({$hue}, 70%, 85%);"
                                    ];
                                })
                                
                            ])
                            //->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->collapsible()
                            ->grid(2) // Atur layout grid
                    ])
                    ->visible(function (?Institusi $record, string $operation): bool {
                        /*logger()->debug('Visibility Check', [
                            'operation' => $operation,
                            'has_children' => $record?->children()->exists(),
                            'record_id' => $record?->id
                        ]);*/
                        // Hanya tampilkan di edit DAN ketika punya children
                        return $operation === 'edit' && $record?->children()->exists();
                    })
                    ->columns(1),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Institusi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parentRelation.name') // Akses relasi parent
                    ->label('Parent')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-'),
                
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInstitusis::route('/'),
            //'create' => Pages\CreateInstitusi::route('/create'),
            //'edit' => Pages\EditInstitusi::route('/{record}/edit'),
        ];
    }

    protected static function getFormValidationRules(?Model $record): array
    {
        return [
            'parent' => [
                'nullable',
                Rule::notIn([$record?->id]), // Hindari memilih diri sendiri
                function ($attribute, $value, $fail) use ($record) {
                    if ($value && Institusi::find($value)?->parent === $record?->id) {
                        $fail('Divisi ini tidak bisa menjadi parent karena sudah menjadi child-nya.');
                    }
                },
            ],
        ];
    }

    private function generateColor(int $index): string
    {
        // Daftar warna pastel (bisa disesuaikan)
        $colors = [
            '#FFD1DC', '#FFECB8', '#D1FFD7', '#D1E3FF', '#E6D1FF',
            '#B8ECFF', '#FFD1D1', '#ECFFB8', '#D1FFEC', '#D1D7FF'
        ];
        return $colors[$index % count($colors)];
    }
}

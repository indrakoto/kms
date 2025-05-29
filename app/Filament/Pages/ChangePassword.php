<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static string $view = 'filament.pages.change-password';
    protected static ?string $title = 'Ganti Password';
    protected static ?int $navigationSort = 10;

    // ✅ Tambahkan properti ini
    public ?string $current_password = '';
    public ?string $password = '';
    public ?string $password_confirmation = '';

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    TextInput::make('current_password')
                        ->label('Password Sekarang')
                        ->password()
                        ->required()
                        ->rule('current_password'),

                    TextInput::make('password')
                        ->label('Password Baru')
                        ->password()
                        ->required()
                        ->minLength(8)
                        ->same('password_confirmation'),

                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->required(),
                ])
        ];
    }

    protected function getFormModel(): \Illuminate\Database\Eloquent\Model|string|null
    {
        return auth()->user(); // Ini agar tidak error seperti sebelumnya
    }

    public function submit(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        Notification::make()
            ->title('Password berhasil diperbarui.')
            ->success()
            ->send();

        // Kosongkan field setelah simpan
        $this->reset(['current_password', 'password', 'password_confirmation']);
    }

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.administrator.pages.dashboard') => 'Dashboard',
            url()->current() => 'Ganti Password',
        ];
    }
}

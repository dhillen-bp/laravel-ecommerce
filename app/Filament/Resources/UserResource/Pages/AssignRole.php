<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Spatie\Permission\Models\Role;

class AssignRole extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.assign-role';

    public User $user;
    public ?int $role = null;
    public string $name = '';

    public function mount(int $record): void
    {
        $this->user = User::findOrFail($record);
        $this->role = $this->user->roles()->first()?->id;
        $this->name = $this->user->name;

        $this->form->fill([
            'name' => $this->user->name,
            'role' => $this->role,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('User Name')
                    ->disabled()
                    ->required(),

                Select::make('role')
                    ->label('Assign Role')
                    ->options(Role::all()->pluck('name', 'id'))
                    ->required(),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Assign Role')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $role = Role::find($data['role']);
        if (!$role) {
            Notification::make()
                ->danger()
                ->title('Role not found.')
                ->send();
            return;
        }

        $this->user->syncRoles($role);

        Notification::make()
            ->success()
            ->title('Role assigned successfully!')
            ->send();

        redirect()->route('filament.admin.resources.users.index');
    }
}

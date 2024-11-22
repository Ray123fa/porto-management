<?php

namespace App\Filament\Resources\TokenResource\Pages;

use App\Filament\Resources\TokenResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Laravel\Sanctum\PersonalAccessToken;

class ListTokens extends ListRecords
{
    protected static string $resource = TokenResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('newToken')
                ->label('New Token') // Label tombol
                ->modalHeading('Create New Token') // Heading modal
                ->form([
                    Forms\Components\Select::make('user_id')
                        ->label('User Email')
                        ->options(User::pluck('email', 'id'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $user = User::find($data['user_id']);
                    if (!$user) {
                        Notification::make()
                            ->title('User Not Found')
                            ->danger()
                            ->body("User {$user->email} not found.")
                            ->send();
                        return;
                    }

                    // Cek apakah user sudah memiliki token
                    $existingToken = PersonalAccessToken::where('tokenable_id', $user->id)->first();
                    if ($existingToken) {
                        Notification::make()
                            ->title('Token Exists')
                            ->warning()
                            ->body("User {$user->email} already has a token.")
                            ->send();
                        return;
                    }

                    // Generate plain token
                    $plainToken = Str::random(40);

                    // Save hashed token to Sanctum
                    $sanctumToken = $user->tokens()->create([
                        'name' => $user->email,
                        'token' => hash('sha256', $plainToken),
                        'abilities' => ['*'],
                    ]);

                    // Save plain token to custom table
                    \App\Models\Token::create([
                        'id' => $user->id,
                        'pat_id' => $sanctumToken->id,
                        'token' => $plainToken,
                    ]);

                    Notification::make()
                        ->title('Token Created')
                        ->success()
                        ->body("Token created successfully for {$user->email}.")
                        ->send();
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokenResource\Pages;
use App\Filament\Resources\TokenResource\RelationManagers;
use App\Models\Token;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('row_number')
                    ->label('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('personalAccessToken.tokenable.email')
                    ->label('User Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('token')
                    ->label('Plain Token')
                    ->getStateUsing(
                        fn($record) => session("unmasked_token_{$record->id}", false) ? $record->token : Str::mask($record->token, '*', 0, strlen($record->token))
                    )
                    ->description('Use the button to reveal or hide it.')
                    ->tooltip('Click to copy token to clipboard.')
                    ->copyable()
                    ->copyMessage('Token copied to clipboard!'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\Action::make('revealToken')
                    ->label(fn($record) => session("unmasked_token_{$record->id}", false) ? 'Hide' : 'Reveal')
                    ->icon(fn($record) => session("unmasked_token_{$record->id}", false) ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color('secondary')
                    ->action(function ($record) {
                        $key = "unmasked_token_{$record->id}";
                        session([$key => !session($key, false)]); // Toggle reveal/unreveal state
                    }),
                Tables\Actions\Action::make('refreshToken')
                    ->label('Refresh')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function ($record) {
                        $plainToken = Str::random(40);

                        $record->personalAccessToken->update([
                            'token' => hash('sha256', $plainToken),
                        ]);

                        $record->update([
                            'token' => $plainToken,
                        ]);

                        Notification::make()
                            ->title('Token Refreshed')
                            ->success()
                            ->body("Token has been refreshed successfully!")
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Refresh Token Confirmation')
                    ->modalDescription('Are you sure you want to refresh the token? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Refresh Token'),
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
            'index' => Pages\ListTokens::route('/'),
        ];
    }
}

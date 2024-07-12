<?php

namespace App\Filament\Resources;

use App\Models\Porto;
use App\Filament\Resources\PortoResource\Pages;
use App\Filament\Resources\PortoResource\RelationManagers;
use App\Helpers\FileHelper;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PortoResource extends Resource
{
    protected static ?string $model = Porto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Heading')
                    ->tabs([
                        Tab::make('Thumbnail Porto')
                            ->columnSpanFull()
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->directory('portos')
                                    ->maxSize(2048)
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        return FileHelper::generateFileName($file);
                                    })
                                    ->required(),
                            ]),
                        Tab::make('Detail Porto')
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TagsInput::make('tags')
                                    ->required()
                                    ->placeholder('Add tags')
                                    ->separator(','),
                                Forms\Components\TextInput::make('url')
                                    ->nullable()
                                    ->maxLength(255),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('tags')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->emptyStateHeading('No posts yet')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPortos::route('/'),
            'create' => Pages\CreatePorto::route('/create'),
            'edit' => Pages\EditPorto::route('/{record}/edit'),
        ];
    }
}

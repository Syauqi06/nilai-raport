<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;
    protected static ?string $modelLabel = 'Kelas'; // Nama buat tombol dan judul
    protected static ?string $pluralModelLabel = 'Kelas'; // Nama buat menu sidebar
    protected static ?string $navigationLabel = 'Kelas'; // Label di navigasi
    protected static ?string $navigationGroup = 'Data Master'; // Grup di navigasi
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kelas') // Membuat section dengan judul
                ->schema([
                    // Input untuk memilih wali kelas menggunakan relasi
                    Forms\Components\Select::make('id_guru')
                        ->label('Wali Kelas') // Label untuk input
                        ->relationship('waliKelas', 'nama') // Menggunakan relasi dari model Guru untuk memilih guru
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Kelas')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\Select::make('tingkat')
                        ->label('Tingkat')
                        ->options([ // Pilihan tingkat kelas
                            '10' => 'Kelas 10',
                            '11' => 'Kelas 11',
                            '12' => 'Kelas 12',
                        ])
                        ->required(),
                ])->columns(2), // Mengatur jumlah kolom dalam section
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('waliKelas.nama') // Menggunakan relasi untuk menampilkan nama wali kelas
                    ->label('Wali Kelas')
                    ->placeholder('Belum ada')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Kelas')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}

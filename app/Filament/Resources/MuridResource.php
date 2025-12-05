<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MuridResource\Pages;
use App\Filament\Resources\MuridResource\RelationManagers;
use App\Models\Murid;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MuridResource extends Resource
{
    protected static ?string $model = Murid::class;
    protected static ?string $modelLabel = 'Murid'; // Nama buat tombol dan judul
    protected static ?string $pluralModelLabel = 'Murid'; // Nama buat menu sidebar
    protected static ?string $navigationLabel = 'Murid'; // Label di navigasi
    protected static ?string $navigationGroup = 'Data Master'; // Grup di navigasi
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Biodata Murid')
                ->schema([
                    Forms\Components\Select::make('id_pengguna') // Relasi ke tabel pengguna untuk login
                        ->label('Akun Pengguna')
                        ->relationship('user', 'username') // Menggunakan relasi ke model User untuk memilih username
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('id_kelas') // Relasi ke tabel kelas
                        ->label('Kelas')
                        ->relationship('kelas', 'nama') // Menggunakan relasi ke model Kelas untuk memilih nama kelas
                        ->searchable()
                        ->required()
                        ->preload(), // Memuat semua opsi saat form dibuka
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nis')
                        ->label('NIS')
                        ->numeric()
                        ->unique(ignoreRecord: true)
                        ->required(),
                    Forms\Components\TextInput::make('nisn')
                        ->label('NISN')
                        ->numeric()
                        ->unique(ignoreRecord: true)
                        ->required(),
                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->displayFormat('d-m-Y')
                        ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id_pengguna')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('id_kelas')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('kelas.nama')
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Akun Login'),
                Tables\Columns\TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date()
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
            'index' => Pages\ListMurids::route('/'),
            'create' => Pages\CreateMurid::route('/create'),
            'edit' => Pages\EditMurid::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;
    protected static ?string $modelLabel = 'Guru'; // Nama buat tombol dan judul
    protected static ?string $pluralModelLabel = 'Data Guru'; // Nama buat menu sidebar
    protected static ?string $navigationLabel = 'Guru'; // Label di navigasi
    protected static ?string $navigationGroup = 'Data Master'; // Grup di navigasi
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profil Guru')
                ->schema([
                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telepon')
                        ->label('Nomor Telepon')
                        ->tel() // Tipe input telepon
                        ->maxLength(20),
                    Forms\Components\Textarea::make('alamat')
                        ->label('Alamat Domisili')
                        ->rows(3)
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('Akun Login')
                ->schema([
                    Forms\Components\Select::make('id_pengguna') // Relasi ke tabel pengguna untuk login
                        ->label('Akun Pengguna')
                        ->relationship('user', 'username') // Menggunakan relasi ke model User untuk memilih username
                        ->searchable()
                        ->required()
                        ->unique(ignoreRecord: true) // Satu user hanya bisa dipakai satu guru
                        ->preload(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Guru')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Nomor Telepon')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username')
                    ->badge() // Membuat tampilan seperti badge
                    ->color('info'), // Warna badge
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}

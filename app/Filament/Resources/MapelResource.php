<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapelResource\Pages;
use App\Filament\Resources\MapelResource\RelationManagers;
use App\Models\Mapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MapelResource extends Resource
{
    protected static ?string $model = Mapel::class;
    protected static ?string $modelLabel = 'Mata Pelajaran'; // Nama buat tombol dan judul
    protected static ?string $pluralModelLabel = 'Mata Pelajaran'; // Nama buat menu sidebar
    protected static ?string $navigationLabel = 'Mata Pelajaran'; // Label di navigasi
    protected static ?string $navigationGroup = 'Data Master'; // Grup di navigasi
    protected static ?string $navigationIcon = 'heroicon-o-book-open'; // Ikon di navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Informasi Mapel') // Membuat section dengan judul
                ->schema([
                    Forms\Components\TextInput::make('kode_mapel')
                        ->label('Kode Mapel')
                        ->required()
                        ->maxLength(10)
                        ->unique(ignoreRecord: true), // Validasi unik, kecuali untuk record yang sedang diedit
                    Forms\Components\TextInput::make('nama_mapel')
                        ->label('Nama Mapel')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('mapel_aktif')
                        ->label('Status Aktif?')
                        ->default(true)
                        ->required(),
                ])->columns(2), // Mengatur jumlah kolom dalam section
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_mapel')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_mapel')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('mapel_aktif') // Membuat kolom toggle untuk status aktif
                    ->label('Aktif'),
                // Tables\Columns\IconColumn::make('mapel_aktif')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at') // Membuat kolom untuk tanggal pembuatan
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Bisa disembunyikan secara default
                Tables\Columns\TextColumn::make('updated_at') // Membuat kolom untuk tanggal pembaruan
                    ->label('Diubah Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // Mengatur sorting default berdasarkan tanggal pembuatan
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
            'index' => Pages\ListMapels::route('/'),
            'create' => Pages\CreateMapel::route('/create'),
            'edit' => Pages\EditMapel::route('/{record}/edit'),
        ];
    }
}

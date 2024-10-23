<?php

namespace App\Filament\Resources\PembelianItemResource\Widgets;

use App\Models\PembelianItem;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class PembelianItemWidget extends BaseWidget
{
    public $pembelianId;

    public function mount($record)
    {
        $this->pembelianId = $record;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                PembelianItem::query()->where('pembelian_id', $this->pembelianId),
            )
            ->columns([
                TextColumn::make('barang.nama')
                    ->label('Nama Barang'),
                TextColumn::make('jumlah')
                    ->label('Jumlah Barang'),
                TextColumn::make('harga')
                    ->label('Harga Barang')->money('IDR')->alignEnd(),
                TextColumn::make('total')->label('Total Harga')
                    ->getStateUsing(function ($record) {
                        return $record->jumlah * $record->harga;
                    })->money('IDR')->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->using(function ($query) {
                                return $query->sum(DB::raw('jumlah * harga'));
                            })->money('IDR')
                    )
            ])->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        TextInput::make('jumlah')
                            ->required()
                    ]),
                Tables\Actions\DeleteAction::make()
            ]);
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $payments;

    public function __construct(Collection $payments)
    {
        $this->payments = $payments;
    }

    /**
     * Mengambil data pembayaran.
     */
    public function collection(): Collection
    {
        return $this->payments;
    }

    /**
     * Membuat judul kolom Excel.
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Penghuni',
            'Nama Kost',
            'Nomor Kamar',
            'Periode Tagihan',
            'Jumlah Pembayaran',
            'Metode Pembayaran',
            'Tanggal Verifikasi',
            'Diverifikasi Oleh',
            'Status',
        ];
    }

    /**
     * Memetakan data pembayaran ke kolom Excel.
     */
    public function map($payment): array
    {
        $assignment = $payment->bill?->roomAssignment;
        $tenant = $assignment?->tenant;
        $room = $assignment?->room;
        $kost = $room?->kost;

        return [
            $payment->id,
            $tenant?->user?->name ?? '-',
            $kost?->name ?? '-',
            $room?->room_number ?? '-',
            $payment->bill?->billing_month ?? '-',
            (float) $payment->amount,
            ucwords(str_replace('_', ' ', $payment->payment_method)),
            $payment->verified_at?->format('d-m-Y H:i') ?? '-',
            $payment->verifiedBy?->name ?? '-',
            strtoupper($payment->status),
        ];
    }
}

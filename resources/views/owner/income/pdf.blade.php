
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Laporan Pemasukan Smart Kost</title>

    <style>
        @page {
            margin: 35px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #493A30;
            background: #FFFFFF;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #684936;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            color: #493126;
            letter-spacing: -1px;
        }

        .logo span {
            color: #B58B6B;
        }

        .subtitle {
            font-size: 9px;
            color: #99877A;
            margin-top: 5px;
        }

        .report-title {
            text-align: center;
            margin-top: 22px;
            margin-bottom: 20px;
        }

        .report-title h1 {
            font-size: 19px;
            color: #493126;
            margin: 0 0 7px;
        }

        .report-title p {
            font-size: 10px;
            color: #99877A;
            margin: 0;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }

        .summary td {
            width: 50%;
            padding: 14px;
            background: #F7F2EB;
            border: 1px solid #E9DED3;
        }

        .summary-label {
            font-size: 9px;
            color: #99877A;
            margin-bottom: 7px;
        }

        .summary-value {
            font-size: 17px;
            font-weight: bold;
            color: #493126;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #493126;
            margin-bottom: 10px;
        }

        .transactions {
            width: 100%;
            border-collapse: collapse;
        }

        .transactions thead {
            display: table-header-group;
        }

        .transactions th {
            background: #493126;
            color: #FFFFFF;
            padding: 10px 7px;
            font-size: 8px;
            text-align: left;
        }

        .transactions td {
            padding: 9px 7px;
            border-bottom: 1px solid #E9DED3;
            font-size: 8px;
        }

        .transactions tr:nth-child(even) {
            background: #F7F2EB;
        }

        .amount {
            font-weight: bold;
            color: #684936;
            white-space: nowrap;
        }

        .status {
            color: #356B42;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #99877A;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #E9DED3;
            text-align: center;
            font-size: 8px;
            color: #99877A;
        }

        .generated {
            text-align: right;
            font-size: 8px;
            color: #99877A;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            smartkost<span>.</span>
        </div>

        <div class="subtitle">
            Smart Kost Management System
        </div>
    </div>


    <!-- JUDUL LAPORAN -->
    <div class="report-title">
        <h1>LAPORAN PEMASUKAN</h1>

        <p>
            Periode:
            @if($month)
                {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
            @else
                Januari - Desember
            @endif

            {{ $year }}
        </p>
    </div>


    <!-- RINGKASAN -->
    <table class="summary">
        <tr>
            <td>
                <div class="summary-label">
                    TOTAL PEMASUKAN
                </div>

                <div class="summary-value">
                    Rp {{ number_format((float) $totalIncome, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="summary-label">
                    TOTAL TRANSAKSI BERHASIL
                </div>

                <div class="summary-value">
                    {{ $transactionCount }} Transaksi
                </div>
            </td>
        </tr>
    </table>


    <!-- TABEL TRANSAKSI -->
    <div class="section-title">
        Detail Riwayat Pemasukan
    </div>

    <table class="transactions">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama Penghuni</th>
                <th>Kost</th>
                <th>Kamar</th>
                <th>Periode Tagihan</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Tanggal Verifikasi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $index => $payment)

                @php
                    $bill = $payment->bill;
                    $assignment = $bill?->roomAssignment;
                    $tenant = $assignment?->tenant;
                    $room = $assignment?->room;
                    $kost = $room?->kost;
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>#{{ $payment->id }}</td>

                    <td>
                        {{ $tenant?->user?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $kost?->name ?? '-' }}
                    </td>

                    <td>
                        {{ $room?->room_number ?? '-' }}
                    </td>

                    <td>
                        {{ $bill?->billing_month ?? '-' }}
                    </td>

                    <td class="amount">
                        Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                    </td>

                    <td>
                        {{ $payment->verified_at?->format('d-m-Y H:i') ?? '-' }}
                    </td>

                    <td class="status">
                        APPROVED
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="10" class="empty">
                        Belum ada transaksi pemasukan pada periode ini.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>


    <!-- TANGGAL GENERATE -->
    <div class="generated">
        Dicetak pada:
        {{ now()->format('d-m-Y H:i') }}
    </div>


    <!-- FOOTER -->
    <div class="footer">
        Smart Kost Management System
        <br>
        Laporan ini dibuat secara otomatis melalui sistem Smart Kost.
    </div>

</body>
</html>

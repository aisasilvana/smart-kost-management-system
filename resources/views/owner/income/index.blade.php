
<x-app-layout>
    <div style="min-height:100vh;background:#F7F2EB;padding:32px 24px;font-family:'Manrope',sans-serif;">
        <div style="max-width:1250px;margin:auto;">

            @php
                $maxMonthlyIncome = max(1, (float) $monthlyIncome->max('total'));
                $totalYearIncome = (float) $monthlyIncome->sum('total');
                $averageIncome = $monthlyIncome->count()
                    ? $totalYearIncome / 12
                    : 0;

                $exportFilters = request()->only(['month', 'year']);
            @endphp

            <!-- HEADER -->
            <div style="margin-bottom:28px;">
                <p style="font-size:11px;font-weight:800;letter-spacing:2px;color:#B58B6B;text-transform:uppercase;">
                    Financial Overview
                </p>

                <h1 style="font-size:30px;font-weight:800;color:#493126;margin-top:8px;">
                    Rekap Pemasukan
                </h1>

                <p style="font-size:14px;color:#99877A;margin-top:6px;">
                    Pantau perkembangan pemasukan dan transaksi kost Anda.
                </p>
            </div>

            <!-- FILTER -->
            <div style="background:white;border:1px solid #E9DED3;border-radius:16px;padding:22px;margin-bottom:22px;">

                <form method="GET" action="{{ route('owner.income.index') }}"
                      style="display:flex;gap:14px;align-items:end;flex-wrap:wrap;">

                    <div style="flex:1;min-width:150px;">
                        <label style="display:block;font-size:12px;font-weight:700;color:#684936;margin-bottom:8px;">
                            Bulan
                        </label>

                        <select name="month"
                                style="width:100%;padding:12px;border:1px solid #E9DED3;border-radius:9px;background:white;">

                            <option value="">Semua Bulan</option>

                            @foreach(range(1, 12) as $number)
                                <option value="{{ $number }}" @selected($month === $number)>
                                    {{ \Carbon\Carbon::create()->month($number)->translatedFormat('F') }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div style="flex:1;min-width:150px;">
                        <label style="display:block;font-size:12px;font-weight:700;color:#684936;margin-bottom:8px;">
                            Tahun
                        </label>

                        <input type="number"
                               name="year"
                               value="{{ $year }}"
                               min="2020"
                               max="2100"
                               required
                               style="width:100%;padding:12px;border:1px solid #E9DED3;border-radius:9px;">
                    </div>

                    <button type="submit"
                            style="background:#684936;color:white;padding:12px 22px;border:0;border-radius:9px;font-weight:700;cursor:pointer;">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('owner.income.index') }}"
                       style="padding:12px 18px;color:#684936;text-decoration:none;border:1px solid #E9DED3;border-radius:9px;font-weight:700;">
                        Reset
                    </a>

                </form>

                <!-- EXPORT BUTTONS -->
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;padding-top:18px;border-top:1px solid #E9DED3;">

                    <a href="{{ route('owner.income.export-excel', $exportFilters) }}"
                       style="display:inline-flex;align-items:center;gap:9px;background:#356B42;color:white;padding:12px 20px;border-radius:9px;text-decoration:none;font-size:13px;font-weight:800;transition:all .2s;">
                        <span style="font-size:17px;">▦</span>
                        Export Excel
                    </a>

                    <a href="{{ route('owner.income.export-pdf', $exportFilters) }}"
                       style="display:inline-flex;align-items:center;gap:9px;background:#684936;color:white;padding:12px 20px;border-radius:9px;text-decoration:none;font-size:13px;font-weight:800;transition:all .2s;">
                        <span style="font-size:17px;">▤</span>
                        Export PDF
                    </a>

                </div>

                <p style="font-size:11px;color:#99877A;margin-top:12px;">
                    File laporan akan mengikuti filter bulan dan tahun yang sedang dipilih.
                </p>

            </div>

            <!-- SUMMARY CARDS -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:18px;margin-bottom:25px;">

                <div style="background:#493126;border-radius:16px;padding:25px;color:white;">
                    <p style="font-size:12px;color:#E7D3BE;">
                        Total Pemasukan
                    </p>

                    <h2 style="font-size:27px;font-weight:800;margin-top:12px;">
                        Rp {{ number_format((float)$totalIncome,0,',','.') }}
                    </h2>

                    <p style="font-size:11px;color:#E7D3BE;margin-top:8px;">
                        Berdasarkan filter yang dipilih
                    </p>
                </div>

                <div style="background:white;border:1px solid #E9DED3;border-radius:16px;padding:25px;">
                    <p style="font-size:12px;color:#99877A;">
                        Transaksi Berhasil
                    </p>

                    <h2 style="font-size:30px;font-weight:800;color:#493126;margin-top:12px;">
                        {{ $transactionCount }}
                    </h2>

                    <p style="font-size:11px;color:#B58B6B;margin-top:8px;">
                        Transaksi berstatus approved
                    </p>
                </div>

                <div style="background:white;border:1px solid #E9DED3;border-radius:16px;padding:25px;">
                    <p style="font-size:12px;color:#99877A;">
                        Rata-rata Pemasukan Bulanan
                    </p>

                    <h2 style="font-size:25px;font-weight:800;color:#493126;margin-top:12px;">
                        Rp {{ number_format($averageIncome,0,',','.') }}
                    </h2>

                    <p style="font-size:11px;color:#B58B6B;margin-top:8px;">
                        Rata-rata dari 12 bulan
                    </p>
                </div>

            </div>

            <!-- INCOME CHART -->
            <div style="background:white;border:1px solid #E9DED3;border-radius:18px;padding:25px;margin-bottom:24px;">

                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:25px;">

                    <div>
                        <h2 style="font-size:19px;font-weight:800;color:#493126;">
                            Grafik Pemasukan Bulanan
                        </h2>

                        <p style="font-size:12px;color:#99877A;margin-top:5px;">
                            Periode Januari – Desember {{ $year }}
                        </p>
                    </div>

                    <span style="background:#F7F2EB;color:#684936;padding:8px 13px;border-radius:20px;font-size:11px;font-weight:800;">
                        TAHUN {{ $year }}
                    </span>

                </div>

                @php
                    $chartMax = max(1, (float) $monthlyIncome->max('total'));
                    $chartSteps = 4;
                @endphp

                <div style="display:flex;gap:12px;min-height:280px;">

                    <!-- Y AXIS -->
                    <div style="display:flex;flex-direction:column;justify-content:space-between;padding-bottom:30px;text-align:right;min-width:65px;">

                        @for($i = $chartSteps; $i >= 0; $i--)
                            <span style="font-size:10px;color:#99877A;">
                                {{ number_format(($chartMax * $i / $chartSteps) / 1000000,1,',','.') }} jt
                            </span>
                        @endfor

                    </div>

                    <!-- BARS -->
                    <div style="flex:1;display:flex;align-items:stretch;border-bottom:1px solid #E9DED3;position:relative;">

                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none;">

                            @for($i = 0; $i < 5; $i++)
                                <div style="border-top:1px dashed #E9DED3;width:100%;"></div>
                            @endfor

                        </div>

                        @foreach($monthlyIncome as $item)

                            @php
                                $barHeight = $item['total'] > 0
                                    ? max(2, ($item['total'] / $chartMax) * 100)
                                    : 0;
                            @endphp

                            <div style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;min-width:0;position:relative;z-index:1;padding:0 3px;">

                                <div title="{{ $item['name'] }}: Rp {{ number_format((float)$item['total'],0,',','.') }}"
                                     style="width:65%;max-width:42px;height:{{ $barHeight }}%;background:linear-gradient(180deg,#B58B6B,#684936);border-radius:7px 7px 0 0;min-height:{{ $item['total'] > 0 ? '3px' : '0' }};transition:height .3s ease;">
                                </div>

                                <span style="font-size:10px;color:#99877A;margin-top:10px;white-space:nowrap;">
                                    {{ substr($item['name'],0,3) }}
                                </span>

                            </div>

                        @endforeach

                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:8px;margin-top:20px;">
                    <span style="width:10px;height:10px;border-radius:3px;background:#684936;"></span>
                    <span style="font-size:11px;color:#99877A;">
                        Total pembayaran yang telah disetujui
                    </span>
                </div>

            </div>

            <!-- MONTHLY SUMMARY -->
            <div style="background:white;border:1px solid #E9DED3;border-radius:16px;padding:24px;margin-bottom:24px;">

                <h2 style="font-size:19px;font-weight:800;color:#493126;margin-bottom:20px;">
                    Ringkasan Pemasukan Bulanan
                </h2>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:13px;">

                    @foreach($monthlyIncome as $item)

                        <div style="background:#F7F2EB;border-radius:12px;padding:17px;">

                            <p style="font-size:12px;color:#99877A;font-weight:700;">
                                {{ $item['name'] }}
                            </p>

                            <h3 style="font-size:18px;font-weight:800;color:#493126;margin-top:8px;">
                                Rp {{ number_format((float)$item['total'],0,',','.') }}
                            </h3>

                            <p style="font-size:11px;color:#B58B6B;margin-top:5px;">
                                {{ $item['transactions'] }} transaksi
                            </p>

                        </div>

                    @endforeach

                </div>
            </div>

            <!-- TRANSACTION HISTORY -->
            <div style="background:white;border:1px solid #E9DED3;border-radius:16px;padding:24px;">

                <div style="margin-bottom:20px;">
                    <h2 style="font-size:19px;font-weight:800;color:#493126;">
                        Riwayat Pemasukan
                    </h2>

                    <p style="font-size:13px;color:#99877A;margin-top:5px;">
                        Daftar pembayaran yang telah diverifikasi Owner.
                    </p>
                </div>

                @forelse($payments as $payment)

                    @php
                        $bill = $payment->bill;
                        $assignment = $bill?->roomAssignment;
                        $tenant = $assignment?->tenant;
                        $room = $assignment?->room;
                        $kost = $room?->kost;
                    @endphp

                    <div style="border:1px solid #E9DED3;border-radius:12px;padding:20px;margin-bottom:14px;">

                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:15px;flex-wrap:wrap;">

                            <div>
                                <p style="font-size:11px;color:#99877A;font-weight:700;">
                                    TRANSAKSI #{{ $payment->id }}
                                </p>

                                <h3 style="font-size:17px;font-weight:800;color:#493126;margin-top:6px;">
                                    {{ $tenant?->user?->name ?? 'Tenant tidak ditemukan' }}
                                </h3>

                                <p style="font-size:12px;color:#99877A;margin-top:5px;">
                                    {{ $kost?->name ?? '-' }}
                                    · Kamar {{ $room?->room_number ?? '-' }}
                                </p>
                            </div>

                            <span style="background:#EAF5EC;color:#356B42;padding:7px 13px;border-radius:20px;font-size:11px;font-weight:800;">
                                APPROVED
                            </span>

                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:15px;margin-top:18px;">

                            <div>
                                <p style="font-size:11px;color:#99877A;">Periode Tagihan</p>
                                <strong style="font-size:13px;color:#493126;">
                                    {{ $bill?->billing_month ?? '-' }}
                                </strong>
                            </div>

                            <div>
                                <p style="font-size:11px;color:#99877A;">Jumlah Pembayaran</p>
                                <strong style="font-size:15px;color:#684936;">
                                    Rp {{ number_format((float)$payment->amount,0,',','.') }}
                                </strong>
                            </div>

                            <div>
                                <p style="font-size:11px;color:#99877A;">Metode Pembayaran</p>
                                <strong style="font-size:13px;color:#493126;">
                                    {{ ucwords(str_replace('_',' ',$payment->payment_method)) }}
                                </strong>
                            </div>

                            <div>
                                <p style="font-size:11px;color:#99877A;">Tanggal Verifikasi</p>
                                <strong style="font-size:13px;color:#493126;">
                                    {{ $payment->verified_at?->format('d M Y, H:i') ?? '-' }}
                                </strong>
                            </div>

                        </div>

                    </div>

                @empty

                    <div style="text-align:center;padding:45px 20px;">
                        <h3 style="font-size:17px;font-weight:800;color:#493126;">
                            Belum Ada Pemasukan
                        </h3>

                        <p style="font-size:13px;color:#99877A;margin-top:8px;">
                            Pembayaran yang disetujui akan muncul di sini.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>


@extends('layouts.app')

@section('content')
<div class="assignment-page">

    <style>
        .assignment-page {
            box-sizing: border-box;
            width: 100%;
            min-width: 0;
            padding: 24px 28px 40px;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
        }

        .assignment-page *,
        .assignment-page *::before,
        .assignment-page *::after {
            box-sizing: border-box;
        }

        .assignment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .assignment-header h1 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.6px;
        }

        .assignment-header p {
            margin: 0;
            color: #99877A;
            font-size: 13px;
        }

        .assignment-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid #684936;
            border-radius: 10px;
            background: #684936;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease, transform .2s ease;
        }

        .assignment-btn:hover {
            transform: translateY(-2px);
            background: #493126;
            color: #fff;
        }

        .assignment-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 26px;
        }

        .summary-card {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 15px;
            padding: 21px;
            border: 1px solid #E9DED3;
            border-radius: 16px;
            background: #fff;
        }

        .summary-icon {
            display: flex;
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .summary-icon svg {
            width: 22px;
            height: 22px;
        }

        .summary-card small {
            display: block;
            margin-bottom: 5px;
            color: #99877A;
            font-size: 11px;
            font-weight: 500;
        }

        .summary-card strong {
            color: #493126;
            font-size: 24px;
            font-weight: 800;
        }

        .assignment-panel {
            width: 100%;
            min-width: 0;
            overflow: hidden;
            border: 1px solid #E9DED3;
            border-radius: 17px;
            background: #fff;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding: 21px 24px;
            border-bottom: 1px solid #EFE5D9;
        }

        .panel-heading h2 {
            margin: 0 0 5px;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .panel-heading p {
            margin: 0;
            color: #99877A;
            font-size: 11px;
        }

        .assignment-count {
            padding: 8px 13px;
            border-radius: 20px;
            background: #F7F2EB;
            color: #684936;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .assignment-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .assignment-table th {
            padding: 15px 18px;
            background: #FBF8F4;
            color: #99877A;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .5px;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .assignment-table td {
            padding: 17px 18px;
            border-bottom: 1px solid #F1EAE3;
            color: #684936;
            font-size: 12px;
            vertical-align: middle;
        }

        .assignment-table tbody tr:last-child td {
            border-bottom: none;
        }

        .assignment-table tbody tr {
            transition: background .2s ease;
        }

        .assignment-table tbody tr:hover {
            background: #FDFBF9;
        }

        .tenant-info {
            display: flex;
            min-width: 180px;
            align-items: center;
            gap: 11px;
        }

        .tenant-avatar {
            display: flex;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #E7D3BE;
            color: #684936;
            font-size: 13px;
            font-weight: 800;
        }

        .tenant-info strong,
        .room-info strong {
            display: block;
            margin-bottom: 4px;
            color: #493126;
            font-size: 12px;
            font-weight: 800;
        }

        .tenant-info small,
        .room-info small {
            color: #99877A;
            font-size: 10px;
        }

        .date-text {
            color: #684936;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-active {
            background: #EAF3E9;
            color: #47734A;
        }

        .status-completed {
            background: #F1EAE3;
            color: #8B654D;
        }

        .status-other {
            background: #FFF3DF;
            color: #A87532;
        }

        .finish-btn {
            padding: 8px 12px;
            border: 1px solid #E9DED3;
            border-radius: 8px;
            background: #fff;
            color: #8B654D;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease;
        }

        .finish-btn:hover {
            border-color: #B58B6B;
            background: #F7F2EB;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            display: flex;
            width: 65px;
            height: 65px;
            align-items: center;
            justify-content: center;
            margin: 0 auto 17px;
            border-radius: 20px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .empty-icon svg {
            width: 29px;
            height: 29px;
        }

        .empty-state h3 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .empty-state p {
            margin: 0 0 20px;
            color: #99877A;
            font-size: 12px;
        }

        .alert-success,
        .alert-error {
            padding: 13px 16px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 12px;
        }

        .alert-success {
            border: 1px solid #D5E7D0;
            background: #EDF5EA;
            color: #47734A;
        }

        .alert-error {
            border: 1px solid #F2D4CC;
            background: #FFF0ED;
            color: #A34E3D;
        }

        @media (max-width: 1100px) {
            .assignment-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .summary-card:last-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 900px) {
            .assignment-page {
                padding: 22px 20px 35px;
            }
        }

        @media (max-width: 600px) {
            .assignment-page {
                padding: 20px 15px 30px;
            }

            .assignment-header {
                align-items: flex-start;
                margin-bottom: 22px;
            }

            .assignment-header h1 {
                font-size: 21px;
            }

            .assignment-header p {
                max-width: 300px;
                line-height: 1.7;
            }

            .assignment-btn {
                width: 100%;
            }

            .assignment-summary {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 20px;
            }

            .summary-card:last-child {
                grid-column: auto;
            }

            .summary-card {
                padding: 17px;
            }

            .panel-heading {
                padding: 18px;
            }
        }
    </style>

    {{-- HEADER --}}
    <div class="assignment-header">
        <div>
            <h1>Penempatan Penghuni</h1>
            <p>Kelola dan pantau penempatan penghuni pada setiap kamar kost.</p>
        </div>

        <a href="{{ route('owner.assignments.create') }}" class="assignment-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Penempatan
        </a>
    </div>

    {{-- NOTIFICATIONS --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- ASSIGNMENT STATISTICS --}}
    @php
        $assignmentData = $assignments ?? collect();

        $totalAssignments = $assignmentData->count();

        $activeAssignments = $assignmentData
            ->where('status', 'active')
            ->count();

        $completedAssignments = $assignmentData
            ->where('status', 'completed')
            ->count();
    @endphp

    <div class="assignment-summary">
        <div class="summary-card">
            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M20 8v6m3-3h-6"/>
                </svg>
            </div>
            <div>
                <small>Total Penempatan</small>
                <strong>{{ $totalAssignments }}</strong>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round">
                    <path d="M3 10.5 12 3l9 7.5V21H3z"/>
                    <path d="M9 21v-7h6v7"/>
                </svg>
            </div>
            <div>
                <small>Penempatan Aktif</small>
                <strong>{{ $activeAssignments }}</strong>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="m8 12 3 3 5-6"/>
                </svg>
            </div>
            <div>
                <small>Penempatan Selesai</small>
                <strong>{{ $completedAssignments }}</strong>
            </div>
        </div>
    </div>

    {{-- ASSIGNMENT TABLE --}}
    <div class="assignment-panel">
        <div class="panel-heading">
            <div>
                <h2>Daftar Penempatan</h2>
                <p>Informasi penghuni dan kamar yang ditempati.</p>
            </div>

            <span class="assignment-count">
                {{ $totalAssignments }} Data
            </span>
        </div>

        @if($assignmentData->isNotEmpty())
            <div class="table-wrapper">
                <table class="assignment-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Penghuni</th>
                            <th>Kost</th>
                            <th>Kamar</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($assignmentData as $assignment)
                            @php
                                $tenantName = $assignment->tenant?->user?->name
                                    ?? 'Penghuni tidak ditemukan';

                                $tenantEmail = $assignment->tenant?->user?->email ?? '-';
                                $roomNumber = $assignment->room?->room_number ?? '-';
                                $kostName = $assignment->room?->kost?->name ?? '-';
                                $status = $assignment->status ?? 'unknown';
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="tenant-info">
                                        <div class="tenant-avatar">
                                            {{ strtoupper(substr($tenantName, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $tenantName }}</strong>
                                            <small>{{ $tenantEmail }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong>{{ $kostName }}</strong>
                                </td>

                                <td>
                                    <div class="room-info">
                                        <strong>Kamar {{ $roomNumber }}</strong>
                                        <small>
                                            @if($assignment->room?->monthly_price !== null)
                                                Rp {{ number_format((float) $assignment->room->monthly_price, 0, ',', '.') }}/bulan
                                            @else
                                                Harga belum tersedia
                                            @endif
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ $assignment->start_date ? \Carbon\Carbon::parse($assignment->start_date)->format('d M Y') : '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="date-text">
                                        {{ $assignment->end_date ? \Carbon\Carbon::parse($assignment->end_date)->format('d M Y') : '-' }}
                                    </span>
                                </td>

                                <td>
                                    @if($status === 'active')
                                        <span class="status-badge status-active">
                                            ● Aktif
                                        </span>
                                    @elseif($status === 'completed')
                                        <span class="status-badge status-completed">
                                            ● Selesai
                                        </span>
                                    @else
                                        <span class="status-badge status-other">
                                            ● {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($status === 'active')
                                        <form
                                            action="{{ route('owner.assignments.finish', $assignment->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah penempatan penghuni ini ingin diselesaikan?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="finish-btn">
                                                Selesaikan
                                            </button>
                                        </form>
                                    @else
                                        <span style="color:#99877A;font-size:11px;">
                                            Tidak ada aksi
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 10.5 12 3l9 7.5V21H3z"/>
                        <path d="M9 21v-7h6v7"/>
                    </svg>
                </div>

                <h3>Belum Ada Penempatan</h3>
                <p>Mulai dengan menempatkan penghuni ke kamar yang tersedia.</p>

                <a href="{{ route('owner.assignments.create') }}" class="assignment-btn">
                    Tambah Penempatan
                </a>
            </div>
        @endif
    </div>

</div>
@endsection

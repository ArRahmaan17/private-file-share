<!DOCTYPE html>
<html lang="en">

<head>
    <x-head />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-primary: #08090d;
            --bg-surface: rgba(255, 255, 255, 0.025);
            --bg-surface-hover: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --text-primary: #f0f0f5;
            --text-secondary: #6b6f80;
            --text-muted: #3d4050;
            --accent: #6366f1;
            --accent-soft: rgba(99, 102, 241, 0.12);
            --green: #34d399;
            --green-soft: rgba(52, 211, 153, 0.1);
            --amber: #fbbf24;
            --amber-soft: rgba(251, 191, 36, 0.1);
            --red: #f87171;
            --red-soft: rgba(248, 113, 113, 0.1);
            --purple: #a78bfa;
            --purple-soft: rgba(167, 139, 250, 0.1);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Ambient background */
        .ambient {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .ambient .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.25;
            animation: drift 25s ease-in-out infinite alternate;
        }

        .ambient .o1 {
            width: 700px;
            height: 700px;
            background: #6366f1;
            top: -30%;
            left: -15%;
        }

        .ambient .o2 {
            width: 500px;
            height: 500px;
            background: #a855f7;
            bottom: -25%;
            right: -10%;
            animation-delay: -8s;
        }

        .ambient .o3 {
            width: 350px;
            height: 350px;
            background: #3b82f6;
            top: 50%;
            left: 60%;
            animation-delay: -15s;
        }

        @keyframes drift {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(40px, -30px) scale(1.05);
            }
        }

        .shell {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 28px 64px;
        }

        /* ---- Topbar ---- */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 28px;
            background: var(--bg-surface);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            margin-bottom: 28px;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.25);
        }

        .topbar-logo svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .topbar-title span {
            color: var(--accent);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            transition: all 0.2s;
        }

        .topbar-link:hover {
            color: var(--text-primary);
            background: var(--bg-surface-hover);
        }

        .topbar-btn {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }

        .topbar-btn:hover {
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        /* ---- Toast ---- */
        .toast {
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast-success {
            background: var(--green-soft);
            color: var(--green);
            border: 1px solid rgba(52, 211, 153, 0.15);
        }

        .toast svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ---- Stats Grid ---- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: var(--bg-surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s;
        }

        .stat-card:hover {
            border-color: var(--border-hover);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.06), transparent);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
        }

        .stat-icon.blue {
            background: var(--accent-soft);
            color: var(--accent);
        }

        .stat-icon.green {
            background: var(--green-soft);
            color: var(--green);
        }

        .stat-icon.amber {
            background: var(--amber-soft);
            color: var(--amber);
        }

        .stat-icon.purple {
            background: var(--purple-soft);
            color: var(--purple);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* ---- File Table ---- */
        .table-wrapper {
            background: var(--bg-surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
        }

        .table-header h2 {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .table-header .badge {
            font-size: 11px;
            font-weight: 600;
            background: var(--accent-soft);
            color: var(--accent);
            padding: 4px 12px;
            border-radius: 100px;
        }

        .files-table {
            width: 100%;
            border-collapse: collapse;
        }

        .files-table thead th {
            text-align: left;
            padding: 12px 24px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .files-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .files-table tbody tr:last-child {
            border-bottom: none;
        }

        .files-table tbody tr:hover {
            background: var(--bg-surface-hover);
        }

        .files-table td {
            padding: 18px 24px;
            vertical-align: middle;
        }

        /* File cell */
        .file-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-soft);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .file-icon svg {
            width: 18px;
            height: 18px;
            color: var(--accent);
        }

        .file-name {
            font-size: 13px;
            font-weight: 600;
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-slug {
            font-size: 11px;
            color: var(--text-muted);
            font-family: 'SF Mono', 'Fira Code', monospace;
            margin-top: 2px;
        }

        /* Badges */
        .badge-row {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .badge-pill {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
            letter-spacing: 0.02em;
        }

        .badge-indigo {
            background: var(--accent-soft);
            color: var(--accent);
        }

        .badge-amber {
            background: var(--amber-soft);
            color: var(--amber);
        }

        /* Expiration cell */
        .expiry-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .expiry-input {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            font-size: 12px;
            color: var(--text-primary);
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            color-scheme: dark;
        }

        .expiry-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        .expiry-save {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.2);
            white-space: nowrap;
        }

        .expiry-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.35);
        }

        .expiry-meta {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 6px;
        }

        .expiry-countdown {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .expiry-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .expiry-dot.live {
            background: var(--green);
            box-shadow: 0 0 6px var(--green);
        }

        .expiry-dot.warn {
            background: var(--amber);
            box-shadow: 0 0 6px var(--amber);
        }

        .expiry-dot.danger {
            background: var(--red);
            box-shadow: 0 0 6px var(--red);
        }

        /* Actions */
        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .action-btn {
            border: none;
            background: none;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, color 0.15s;
        }

        .action-btn svg {
            width: 16px;
            height: 16px;
        }

        .action-btn.view {
            color: var(--accent);
        }

        .action-btn.view:hover {
            background: var(--accent-soft);
        }

        .action-btn.delete {
            color: var(--red);
        }

        .action-btn.delete:hover {
            background: var(--red-soft);
        }

        .action-btn.copy {
            color: var(--text-secondary);
        }

        .action-btn.copy:hover {
            background: var(--bg-surface-hover);
            color: var(--text-primary);
        }

        /* Empty state */
        .empty-state {
            padding: 64px 24px;
            text-align: center;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: var(--bg-surface-hover);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .empty-icon svg {
            width: 28px;
            height: 28px;
            color: var(--text-muted);
        }

        .empty-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* Storage bar */
        .storage-bar-bg {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 100px;
            overflow: hidden;
        }

        .storage-bar-fill {
            height: 100%;
            border-radius: 100px;
            transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Responsive table */
        .table-scroll {
            overflow-x: auto;
        }

        /* Tooltip */
        .tooltip-wrap {
            position: relative;
        }

        .tooltip-wrap:hover .tooltip {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .tooltip {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            background: #1a1b23;
            border: 1px solid var(--border);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s, transform 0.15s;
            z-index: 10;
        }

        /* Page entrance */
        .shell {
            animation: pageIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes pageIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="ambient">
        <div class="orb o1"></div>
        <div class="orb o2"></div>
        <div class="orb o3"></div>
    </div>

    <div class="shell">

        {{-- Topbar --}}
        <nav class="topbar">
            <div class="topbar-brand">
                <div class="topbar-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <div class="topbar-title">File<span>Stream</span></div>
            </div>
            <div class="topbar-actions">
                <a href="/" class="topbar-link">← Home</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="topbar-btn">Sign Out</button>
                </form>
            </div>
        </nav>

        {{-- Toast --}}
        @if(session('success'))
        <div class="toast toast-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $files->count() }}</div>
                <div class="stat-label">Active Files</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                    </svg>
                </div>
                <div class="stat-value">
                    @if($totalFileSize >= 1073741824)
                    {{ number_format($totalFileSize / 1073741824, 1) }}<small style="font-size:14px;font-weight:500;color:var(--text-secondary)"> GB</small>
                    @elseif($totalFileSize >= 1048576)
                    {{ number_format($totalFileSize / 1048576, 1) }}<small style="font-size:14px;font-weight:500;color:var(--text-secondary)"> MB</small>
                    @else
                    {{ number_format($totalFileSize / 1024, 0) }}<small style="font-size:14px;font-weight:500;color:var(--text-secondary)"> KB</small>
                    @endif
                </div>
                <div class="stat-label">Total Upload Size</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $files->where('password', '!=', null)->count() }}</div>
                <div class="stat-label">Protected Files</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="stat-value">{{ $diskUsedPercent }}<small style="font-size:14px;font-weight:500;color:var(--text-secondary)">%</small></div>
                <div class="stat-label">Disk Used</div>
                <div style="margin-top:10px">
                    <div class="storage-bar-bg">
                        <div class="storage-bar-fill" style="width: {{ $diskUsedPercent }}%; background: {{ $diskUsedPercent > 85 ? 'var(--red)' : ($diskUsedPercent > 60 ? 'var(--amber)' : 'var(--green)') }};"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- File Table --}}
        <div class="table-wrapper">
            <div class="table-header">
                <h2>Uploaded Files</h2>
                <span class="badge">{{ $files->count() }} {{ Str::plural('file', $files->count()) }}</span>
            </div>

            @if($files->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <div class="empty-title">No files uploaded yet</div>
                <div class="empty-desc">Upload a file from the homepage to see it here.</div>
            </div>
            @else
            <div class="table-scroll">
                <table class="files-table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Status</th>
                            <th>Expiration</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $file)
                        @php
                        $hoursLeft = now()->diffInHours($file->expires_at, false);
                        $dotClass = $hoursLeft > 12 ? 'live' : ($hoursLeft > 3 ? 'warn' : 'danger');
                        @endphp
                        <tr>
                            <td>
                                <div class="file-info">
                                    <div class="file-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="file-name">{{ $file->original_name }}</div>
                                        <div class="file-slug">{{ $file->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="badge-row">
                                    @if($file->password)
                                    <span class="badge-pill badge-indigo">🔒 Protected</span>
                                    @endif
                                    @if($file->is_one_time)
                                    <span class="badge-pill badge-amber">⚡ One-time</span>
                                    @endif
                                    @if(!$file->password && !$file->is_one_time)
                                    <span class="badge-pill" style="background:var(--bg-surface-hover);color:var(--text-secondary)">Public</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.update', $file->id) }}" method="POST" class="expiry-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="datetime-local" name="expires_at"
                                        value="{{ $file->expires_at->format('Y-m-d\TH:i') }}"
                                        class="expiry-input">
                                    <button type="submit" class="expiry-save">Save</button>
                                </form>
                                <div class="expiry-meta">
                                    <span class="expiry-countdown">
                                        <span class="expiry-dot {{ $dotClass }}"></span>
                                        {{ $file->expires_at->diffForHumans() }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="action-group">
                                    <div class="tooltip-wrap">
                                        <a href="{{ route('show', $file->slug) }}" target="_blank" class="action-btn view" title="View">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                        <span class="tooltip">Open link</span>
                                    </div>
                                    <div class="tooltip-wrap">
                                        <button class="action-btn copy" onclick="copySlug('{{ route('show', $file->slug) }}', this)" title="Copy link">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                        <span class="tooltip">Copy link</span>
                                    </div>
                                    <div class="tooltip-wrap">
                                        <form action="{{ route('admin.destroy', $file->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Permanently delete this file?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        <span class="tooltip">Delete file</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <script>
        function copySlug(url, btn) {
            navigator.clipboard.writeText(url).then(() => {
                const svg = btn.querySelector('svg');
                const originalPath = svg.innerHTML;
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>';
                btn.style.color = 'var(--green)';
                setTimeout(() => {
                    svg.innerHTML = originalPath;
                    btn.style.color = '';
                }, 1500);
            });
        }
    </script>
</body>

</html>
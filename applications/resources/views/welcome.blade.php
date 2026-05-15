<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="FileStream - Simple, Secure File Sharing"
        description="High-performance, ephemeral file sharing with 1-hour expiration and password protection." />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            color-scheme: light;
            --bg-primary: #fff6f6;
            --bg-secondary: #8cc7c4;
            --bg-card: rgba(255, 246, 246, 0.72);
            --bg-card-hover: rgba(255, 246, 246, 0.92);
            --surface-subtle: rgba(44, 104, 123, 0.06);
            --surface-raised: rgba(255, 246, 246, 0.58);
            --field-bg: rgba(255, 246, 246, 0.96);
            --border: rgba(44, 104, 123, 0.16);
            --border-hover: rgba(44, 104, 123, 0.3);
            --text-primary: #2c687b;
            --text-secondary: #2c687b;
            --text-muted: rgba(44, 104, 123, 0.62);
            --accent: #db1a1a;
            --accent-strong: #2c687b;
            --accent-glow: rgba(219, 26, 26, 0.2);
            --success: #2c687b;
            --success-glow: rgba(140, 199, 196, 0.24);
            --danger: #db1a1a;
            --panel-shadow: 0 24px 64px rgba(44, 104, 123, 0.14);
            --panel-shine: linear-gradient(90deg, transparent, rgba(44, 104, 123, 0.16), transparent);
            --brand-gradient: linear-gradient(135deg, #db1a1a, #2c687b);
            --heading-gradient: linear-gradient(135deg, #db1a1a 0%, #2c687b 100%);
            --progress-gradient: linear-gradient(90deg, #db1a1a, #2c687b);
            --success-gradient: linear-gradient(135deg, #8cc7c4, #2c687b);
            --track-bg: rgba(44, 104, 123, 0.12);
            --icon-hover-bg: #2c687b;
            --orb-1: #db1a1a;
            --orb-2: #8cc7c4;
            --orb-3: #2c687b;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                color-scheme: dark;
                --bg-primary: #1e104e;
                --bg-secondary: #452e5a;
                --bg-card: rgba(255, 255, 255, 0.05);
                --bg-card-hover: rgba(255, 255, 255, 0.09);
                --surface-subtle: rgba(255, 255, 255, 0.03);
                --surface-raised: rgba(255, 255, 255, 0.06);
                --field-bg: rgba(255, 255, 255, 0.08);
                --border: rgba(255, 200, 92, 0.14);
                --border-hover: rgba(255, 200, 92, 0.3);
                --text-primary: #fff7dc;
                --text-secondary: rgba(255, 239, 191, 0.84);
                --text-muted: rgba(255, 239, 191, 0.5);
                --accent: #ff653f;
                --accent-strong: #ffc85c;
                --accent-glow: rgba(255, 101, 63, 0.28);
                --success: #ffc85c;
                --success-glow: rgba(255, 200, 92, 0.22);
                --danger: #ff653f;
                --panel-shadow: 0 24px 64px rgba(18, 0, 40, 0.42);
                --panel-shine: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.14), transparent);
                --brand-gradient: linear-gradient(135deg, #452e5a, #ff653f);
                --heading-gradient: linear-gradient(135deg, #ffffff 0%, #ffc85c 100%);
                --progress-gradient: linear-gradient(90deg, #ff653f, #ffc85c);
                --success-gradient: linear-gradient(135deg, #ff653f, #ffc85c);
                --track-bg: rgba(255, 255, 255, 0.12);
                --icon-hover-bg: #fff2fb;
                --orb-1: #452e5a;
                --orb-2: #ff653f;
                --orb-3: #ffc85c;
            }
        }

        html[data-theme="light"] {
            color-scheme: light;
            --bg-primary: #fff6f6;
            --bg-secondary: #8cc7c4;
            --bg-card: rgba(255, 246, 246, 0.72);
            --bg-card-hover: rgba(255, 246, 246, 0.92);
            --surface-subtle: rgba(44, 104, 123, 0.06);
            --surface-raised: rgba(255, 246, 246, 0.58);
            --field-bg: rgba(255, 246, 246, 0.96);
            --border: rgba(44, 104, 123, 0.16);
            --border-hover: rgba(44, 104, 123, 0.3);
            --text-primary: #2c687b;
            --text-secondary: #2c687b;
            --text-muted: rgba(44, 104, 123, 0.62);
            --accent: #db1a1a;
            --accent-strong: #2c687b;
            --accent-glow: rgba(219, 26, 26, 0.2);
            --success: #2c687b;
            --success-glow: rgba(140, 199, 196, 0.24);
            --danger: #db1a1a;
            --panel-shadow: 0 24px 64px rgba(44, 104, 123, 0.14);
            --panel-shine: linear-gradient(90deg, transparent, rgba(44, 104, 123, 0.16), transparent);
            --brand-gradient: linear-gradient(135deg, #db1a1a, #2c687b);
            --heading-gradient: linear-gradient(135deg, #db1a1a 0%, #2c687b 100%);
            --progress-gradient: linear-gradient(90deg, #db1a1a, #2c687b);
            --success-gradient: linear-gradient(135deg, #8cc7c4, #2c687b);
            --track-bg: rgba(44, 104, 123, 0.12);
            --icon-hover-bg: #2c687b;
            --orb-1: #db1a1a;
            --orb-2: #8cc7c4;
            --orb-3: #2c687b;
        }

        html[data-theme="dark"] {
            color-scheme: dark;
            --bg-primary: #1e104e;
            --bg-secondary: #452e5a;
            --bg-card: rgba(255, 255, 255, 0.05);
            --bg-card-hover: rgba(255, 255, 255, 0.09);
            --surface-subtle: rgba(255, 255, 255, 0.03);
            --surface-raised: rgba(255, 255, 255, 0.06);
            --field-bg: rgba(255, 255, 255, 0.08);
            --border: rgba(255, 200, 92, 0.14);
            --border-hover: rgba(255, 200, 92, 0.3);
            --text-primary: #fff7dc;
            --text-secondary: rgba(255, 239, 191, 0.84);
            --text-muted: rgba(255, 239, 191, 0.5);
            --accent: #ff653f;
            --accent-strong: #ffc85c;
            --accent-glow: rgba(255, 101, 63, 0.28);
            --success: #ffc85c;
            --success-glow: rgba(255, 200, 92, 0.22);
            --danger: #ff653f;
            --panel-shadow: 0 24px 64px rgba(18, 0, 40, 0.42);
            --panel-shine: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.14), transparent);
            --brand-gradient: linear-gradient(135deg, #452e5a, #ff653f);
            --heading-gradient: linear-gradient(135deg, #ffffff 0%, #ffc85c 100%);
            --progress-gradient: linear-gradient(90deg, #ff653f, #ffc85c);
            --success-gradient: linear-gradient(135deg, #ff653f, #ffc85c);
            --track-bg: rgba(255, 255, 255, 0.12);
            --icon-hover-bg: #fff2fb;
            --orb-1: #452e5a;
            --orb-2: #ff653f;
            --orb-3: #ffc85c;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.24), transparent 30%),
                linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .ambient {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.35;
            animation: breathe 25s ease-in-out infinite alternate;
        }

        .o1 {
            width: 600px;
            height: 600px;
            background: var(--orb-1);
            top: -20%;
            left: -10%;
        }

        .o2 {
            width: 500px;
            height: 500px;
            background: var(--orb-2);
            bottom: -20%;
            right: -10%;
            animation-delay: -5s;
        }

        .o3 {
            width: 400px;
            height: 400px;
            background: var(--orb-3);
            top: 40%;
            left: 50%;
            animation-delay: -10s;
            transform: translate(-50%, -50%);
        }

        @keyframes breathe {
            0% {
                transform: scale(1) translate(0, 0);
            }

            100% {
                transform: scale(1.1) translate(30px, -30px);
            }
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 640px;
            margin: auto;
            padding: 40px 24px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        header {
            text-align: center;
        }

        .header-tools {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            background: var(--surface-raised);
            color: var(--text-primary);
            border-radius: 999px;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-1px);
        }

        .theme-toggle svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: var(--brand-gradient);
            box-shadow: 0 12px 32px var(--accent-glow);
            margin-bottom: 24px;
        }

        .logo-wrap svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        h1 {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 12px;
            background: var(--heading-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            font-weight: 400;
        }

        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(40px) saturate(1.5);
            -webkit-backdrop-filter: blur(40px) saturate(1.5);
            border: 1px solid var(--border);
            border-radius: 32px;
            padding: 40px;
            box-shadow: var(--panel-shadow);
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--panel-shine);
        }

        .drop-zone {
            border: 2px dashed var(--border-hover);
            border-radius: 24px;
            padding: 48px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            background: var(--surface-subtle);
            margin-bottom: 32px;
        }

        .drop-zone:hover,
        .drop-zone.active {
            border-color: var(--accent);
            background: var(--accent-glow);
        }

        .drop-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 16px;
            background: var(--bg-card-hover);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            transition: transform 0.3s;
        }

        .drop-zone:hover .drop-icon {
            transform: translateY(-4px);
            background: var(--icon-hover-bg);
        }

        .drop-zone:hover .drop-icon svg {
            color: var(--accent);
        }

        .drop-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .drop-desc {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 500px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            padding-left: 4px;
        }

        .input-field {
            background: var(--field-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
        }

        .input-field:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .input-field::placeholder {
            color: var(--text-muted);
        }

        .toggle-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 10px;
            border-radius: 14px;
            background: var(--surface-subtle);
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-wrap:hover {
            background: var(--bg-card-hover);
            border-color: var(--border);
        }

        .toggle-switch {
            width: 36px;
            height: 20px;
            border-radius: 20px;
            background: var(--border-hover);
            position: relative;
            flex-shrink: 0;
            transition: background 0.3s;
            margin-top: 2px;
        }

        .toggle-knob {
            width: 14px;
            height: 14px;
            background: var(--icon-hover-bg);
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked+.toggle-wrap .toggle-switch {
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent-glow);
        }

        input[type="checkbox"]:checked+.toggle-wrap .toggle-knob {
            transform: translateX(16px);
        }

        .toggle-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .toggle-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .toggle-desc {
            font-size: 9px;
            color: var(--text-secondary);
        }

        .progress-box {
            text-align: center;
            padding: 24px 0;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .progress-name {
            color: var(--text-primary);
            max-width: 70%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .progress-pct {
            color: var(--accent);
            font-variant-numeric: tabular-nums;
        }

        .progress-track {
            width: 100%;
            height: 8px;
            background: var(--track-bg);
            border-radius: 100px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--progress-gradient);
            border-radius: 100px;
            width: 0%;
            transition: width 0.1s linear;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--success-glow);
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .success-icon svg {
            width: 32px;
            height: 32px;
        }

        .result-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }

        .link-copier {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 24px;
        }

        .link-input {
            flex: 1;
            background: var(--field-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            color: var(--text-primary);
            font-size: 14px;
            outline: none;
            font-family: inherit;
            read-only: true;
        }

        .btn-primary {
            background: var(--brand-gradient);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 16px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            box-shadow: 0 4px 20px var(--accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px var(--accent-glow);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border-hover);
            color: var(--text-primary);
            border-radius: 14px;
            padding: 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-secondary:hover {
            background: var(--bg-card-hover);
            border-color: var(--border);
        }

        .hidden {
            display: none !important;
        }

        .animate-enter {
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            text-align: center;
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 400;
            padding: 40px 0 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            opacity: 0.8;
        }

        .footer-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            padding: 12px 24px;
            background: var(--surface-raised);
            border-radius: 100px;
            width: fit-content;
            margin: 0 auto;
            border: 1px solid var(--border);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        .stat-value {
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .recent-panel {
            padding: 28px;
        }

        .recent-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .recent-panel-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .recent-panel-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .text-btn {
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s;
        }

        .text-btn:hover {
            color: var(--text-primary);
        }

        .recent-links-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .recent-link-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            padding: 14px 16px;
            border-radius: 18px;
            background: var(--surface-subtle);
            border: 1px solid var(--border);
        }

        .recent-link-meta {
            min-width: 0;
        }

        .recent-link-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recent-link-url {
            margin-top: 4px;
            font-size: 12px;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recent-link-age {
            margin-top: 6px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .recent-link-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .chip-btn {
            border: 1px solid var(--border);
            background: var(--surface-raised);
            color: var(--text-primary);
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chip-btn:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
        }

        .recent-empty {
            padding: 18px;
            border-radius: 18px;
            border: 1px dashed var(--border-hover);
            color: var(--text-secondary);
            font-size: 13px;
            text-align: center;
            background: var(--surface-subtle);
        }

        @media (max-width: 560px) {
            .recent-link-item {
                grid-template-columns: 1fr;
            }

            .recent-link-actions {
                width: 100%;
            }

            .chip-btn {
                flex: 1;
                text-align: center;
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

    <div class="container animate-enter">
        <header>
            <div class="header-tools">
                <button type="button" id="theme-toggle" class="theme-toggle" aria-label="Toggle color theme"></button>
            </div>
            <div class="logo-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            </div>
            <h1>FileStream</h1>
            <p class="subtitle">Secure, ephemeral (1-hour) file sharing built for speed.</p>
        </header>

        <main class="glass-panel">
            <!-- Stage 1: Upload -->
            <div id="upload-stage">
                <div id="drop-zone" class="drop-zone">
                    <div class="drop-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <div class="drop-title">Drop your file here</div>
                    <div class="drop-desc">or click to browse (Max 1GB)</div>
                    <input type="file" id="file-input" class="hidden"
                        accept=".pdf,.zip,.rar,.7z,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt,.csv,.mp4,.mp3">
                </div>

                <!-- Selected File Preview (Hidden by default) -->
                <div id="file-preview-wrap" class="hidden"
                    style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: var(--surface-raised); border: 1px solid var(--border); border-radius: 20px; margin-bottom: 32px; transition: all 0.3s ease;">
                    <div style="display: flex; align-items: center; gap: 16px; overflow: hidden;">
                        <div
                            style="width: 48px; height: 48px; border-radius: 12px; background: var(--bg-card-hover); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                style="color: var(--accent);">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div style="overflow: hidden; text-align: left;">
                            <div id="selected-file-name"
                                style="font-size: 15px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px; color: var(--text-primary);">
                                filename.pdf</div>
                            <div id="selected-file-size" style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">2.4 MB</div>
                        </div>
                    </div>
                    <button type="button" id="clear-file-btn"
                        style="background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 8px; border-radius: 50%; transition: all 0.2s;"
                        onmouseover="this.style.color='var(--danger)'; this.style.background='var(--bg-card-hover)'"
                        onmouseout="this.style.color='var(--text-muted)'; this.style.background='none'">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="options-grid">
                    <div class="form-group">
                        <label class="label" for="password">Password Protection</label>
                        <input type="password" id="password" class="input-field" placeholder="Optional password">
                    </div>
                    <div class="form-group">
                        <label class="label">Security</label>
                        <input type="checkbox" id="is_one_time">
                        <label for="is_one_time" class="toggle-wrap">
                            <div class="toggle-switch">
                                <div class="toggle-knob"></div>
                            </div>
                            <div class="toggle-text">
                                <span class="toggle-title">Self-destruct</span>
                                <span class="toggle-desc">Burn after reading</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="button" id="start-upload-btn" class="btn-primary"
                    style="width: 100%; margin-top: 24px; opacity: 0.5; pointer-events: none; justify-content: center; display: flex; align-items: center; gap: 10px;">Select
                    a file to upload</button>
            </div>

            <!-- Stage 2: Progress -->
            <div id="progress-stage" class="hidden progress-box">
                <div class="logo-wrap" style="width: 48px; height: 48px; margin-bottom: 24px; animation: breathe 2s infinite alternate;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </div>
                <div class="progress-meta">
                    <span id="file-name" class="progress-name">Connecting...</span>
                    <span id="progress-percent" class="progress-pct">0%</span>
                </div>
                <div class="progress-track">
                    <div id="progress-bar" class="progress-fill"></div>
                </div>
                <p style="margin-top: 16px; font-size: 13px; color: var(--text-secondary);">Encrypting & transferring...</p>
            </div>

            <!-- Stage 3: Result -->
            <div id="result-stage" class="hidden">
                <div class="success-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="result-title">Ready to share</div>

                <div class="link-copier">
                    <input type="text" id="share-link" class="link-input" readonly>
                    <button id="copy-btn" class="btn-primary">Copy Link</button>
                </div>

                <p style="margin-top: 14px; font-size: 12px; color: var(--text-secondary); text-align: center;">
                    This link is stored in your browser for up to 1 hour on this device.
                </p>

                <button type="button" id="share-another-btn" class="btn-secondary">Share another file</button>
            </div>
        </main>

        <section id="recent-links-panel" class="glass-panel recent-panel hidden">
            <div class="recent-panel-head">
                <div>
                    <div class="recent-panel-title">Recent Local Links</div>
                    <p class="recent-panel-subtitle">Stored only in this browser for up to 1 hour.</p>
                </div>
                <button type="button" id="clear-history-btn" class="text-btn hidden">Clear history</button>
            </div>
            <div id="recent-links-list" class="recent-links-list"></div>
        </section>

        <footer>
            <div class="footer-stats">
                <div class="stat-item">
                    <div class="stat-dot"></div>
                    <span class="stat-value">{{ $totalFiles }}</span>
                    <span class="stat-label">Active Files</span>
                </div>
                <div style="width: 1px; height: 16px; background: var(--border);"></div>
                <div class="stat-item">
                    <div class="stat-dot" style="background: var(--success); box-shadow: 0 0 8px var(--success);"></div>
                    <span class="stat-value">
                        @if ($totalSize >= 1073741824)
                        {{ number_format($totalSize / 1073741824, 1) }} GB
                        @elseif($totalSize >= 1048576)
                        {{ number_format($totalSize / 1048576, 1) }} MB
                        @else
                        {{ number_format($totalSize / 1024, 0) }} KB
                        @endif
                    </span>
                    <span class="stat-label">Handled Storage</span>
                </div>
            </div>
            <p>FileStream &copy; 2026. Secure, encrypted, and ephemeral.</p>
        </footer>
    </div>

    <script>
        const maxUploadBytes = 1024 * 1024 * 1024; // 1 GB
        const storedLinkKey = 'filestream:last-share-link';
        const recentLinksKey = 'filestream:recent-share-links';
        const storedLinkTtlMs = 60 * 60 * 1000; // 1 hour
        const maxRecentLinks = 6;
        const themeStorageKey = 'filestream:theme';
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const uploadStage = document.getElementById('upload-stage');
        const progressStage = document.getElementById('progress-stage');
        const resultStage = document.getElementById('result-stage');
        const progressBar = document.getElementById('progress-bar');
        const progressPercent = document.getElementById('progress-percent');
        const fileNameLabel = document.getElementById('file-name');
        const shareLinkInput = document.getElementById('share-link');
        const copyBtn = document.getElementById('copy-btn');
        const shareAnotherBtn = document.getElementById('share-another-btn');
        const recentLinksPanel = document.getElementById('recent-links-panel');
        const recentLinksList = document.getElementById('recent-links-list');
        const clearHistoryBtn = document.getElementById('clear-history-btn');
        const themeToggle = document.getElementById('theme-toggle');

        let selectedFile = null;

        dropZone.onclick = () => fileInput.click();

        initializeTheme();
        restoreStoredLink();
        renderRecentLinks();

        function getSystemTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        function getStoredTheme() {
            const storedTheme = localStorage.getItem(themeStorageKey);
            return storedTheme === 'light' || storedTheme === 'dark' ? storedTheme : null;
        }

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            updateThemeToggle(theme);
        }

        function updateThemeToggle(theme) {
            const nextTheme = theme === 'dark' ? 'light' : 'dark';
            const icon = theme === 'dark'
                ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.5m0 13V21m9-9h-2.5M5.5 12H3m14.864 6.364l-1.768-1.768M7.904 7.904L6.136 6.136m11.728 0l-1.768 1.768M7.904 16.096l-1.768 1.768M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>'
                : '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646a9 9 0 1011.708 11.708z" /></svg>';

            themeToggle.innerHTML = `${icon}<span>${theme === 'dark' ? 'Dark Theme' : 'Light Theme'}</span>`;
            themeToggle.setAttribute('title', `Switch to ${nextTheme} theme`);
            themeToggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        }

        function initializeTheme() {
            const savedTheme = getStoredTheme();
            applyTheme(savedTheme || getSystemTheme());

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!getStoredTheme()) {
                    applyTheme(getSystemTheme());
                }
            });
        }

        function updateFilePreview(file) {
            if (!file) {
                selectedFile = null;
                document.getElementById('drop-zone').classList.remove('hidden');
                document.getElementById('file-preview-wrap').classList.add('hidden');
                const btn = document.getElementById('start-upload-btn');
                btn.style.opacity = '0.5';
                btn.style.pointerEvents = 'none';
                btn.innerHTML = 'Select a file to upload';
                document.getElementById('file-input').value = '';
                return;
            }

            if (file.size > maxUploadBytes) {
                alert('File is too large (Max 1GB).');
                return;
            }

            const allowedExt = ['.pdf', '.zip', '.rar', '.7z', '.doc', '.docx', '.xls', '.xlsx', '.jpg', '.jpeg', '.png', '.txt', '.csv', '.mp4', '.mp3'];
            const fileExt = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
            if (!allowedExt.includes(fileExt)) {
                alert('File type not allowed. Please upload common formats (ZIP, PDF, etc.).');
                return;
            }

            selectedFile = file;
            document.getElementById('drop-zone').classList.add('hidden');
            const previewWrap = document.getElementById('file-preview-wrap');
            previewWrap.classList.remove('hidden');

            document.getElementById('selected-file-name').textContent = file.name;

            let size = file.size;
            let sizeStr = '';
            if (size >= 1073741824) {
                sizeStr = (size / 1073741824).toFixed(1) + ' GB';
            } else if (size >= 1048576) {
                sizeStr = (size / 1048576).toFixed(1) + ' MB';
            } else {
                sizeStr = (size / 1024).toFixed(0) + ' KB';
            }
            document.getElementById('selected-file-size').textContent = sizeStr;

            const btn = document.getElementById('start-upload-btn');
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            btn.innerHTML =
                '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg> Upload File';
        }

        document.getElementById('clear-file-btn').onclick = (e) => {
            e.preventDefault();
            updateFilePreview(null);
        };

        fileInput.onchange = (e) => updateFilePreview(e.target.files[0]);

        dropZone.ondragover = (e) => {
            e.preventDefault();
            dropZone.classList.add('active');
        };
        dropZone.ondragleave = () => dropZone.classList.remove('active');
        dropZone.ondrop = (e) => {
            e.preventDefault();
            dropZone.classList.remove('active');
            updateFilePreview(e.dataTransfer.files[0]);
        };

        document.getElementById('start-upload-btn').onclick = () => {
            if (selectedFile) handleUpload(selectedFile);
        };

        function persistShareLink(url, fileName) {
            const entry = {
                url,
                file_name: fileName || 'Shared file',
                saved_at: Date.now()
            };

            localStorage.setItem(storedLinkKey, JSON.stringify({
                url,
                saved_at: Date.now()
            }));

            const recentLinks = getRecentLinks().filter((item) => item.url !== url);
            recentLinks.unshift(entry);
            localStorage.setItem(recentLinksKey, JSON.stringify(recentLinks.slice(0, maxRecentLinks)));
            renderRecentLinks();
        }

        function getStoredLink() {
            const raw = localStorage.getItem(storedLinkKey);
            if (!raw) {
                return null;
            }

            try {
                const parsed = JSON.parse(raw);
                if (!parsed.url || !parsed.saved_at) {
                    localStorage.removeItem(storedLinkKey);
                    return null;
                }

                if ((Date.now() - parsed.saved_at) > storedLinkTtlMs) {
                    localStorage.removeItem(storedLinkKey);
                    return null;
                }

                return parsed;
            } catch (error) {
                localStorage.removeItem(storedLinkKey);
                return null;
            }
        }

        function getRecentLinks() {
            const raw = localStorage.getItem(recentLinksKey);
            if (!raw) {
                return [];
            }

            try {
                const parsed = JSON.parse(raw);
                if (!Array.isArray(parsed)) {
                    localStorage.removeItem(recentLinksKey);
                    return [];
                }

                const validEntries = parsed.filter((item) => {
                    return item && item.url && item.saved_at && ((Date.now() - item.saved_at) <= storedLinkTtlMs);
                });

                if (validEntries.length !== parsed.length) {
                    localStorage.setItem(recentLinksKey, JSON.stringify(validEntries.slice(0, maxRecentLinks)));
                }

                return validEntries.slice(0, maxRecentLinks);
            } catch (error) {
                localStorage.removeItem(recentLinksKey);
                return [];
            }
        }

        function renderRecentLinks() {
            const recentLinks = getRecentLinks();
            recentLinksList.innerHTML = '';

            if (recentLinks.length === 0) {
                recentLinksPanel.classList.add('hidden');
                clearHistoryBtn.classList.add('hidden');
                return;
            }

            recentLinksPanel.classList.remove('hidden');
            clearHistoryBtn.classList.remove('hidden');

            recentLinks.forEach((item) => {
                const row = document.createElement('div');
                row.className = 'recent-link-item';

                const meta = document.createElement('div');
                meta.className = 'recent-link-meta';

                const name = document.createElement('div');
                name.className = 'recent-link-name';
                name.textContent = item.file_name || 'Shared file';

                const url = document.createElement('div');
                url.className = 'recent-link-url';
                url.textContent = item.url;

                const age = document.createElement('div');
                age.className = 'recent-link-age';
                age.textContent = formatRecentLinkAge(item.saved_at);

                meta.appendChild(name);
                meta.appendChild(url);
                meta.appendChild(age);

                const actions = document.createElement('div');
                actions.className = 'recent-link-actions';

                const openBtn = document.createElement('a');
                openBtn.className = 'chip-btn';
                openBtn.href = item.url;
                openBtn.textContent = 'Open';

                const copyRecentBtn = document.createElement('button');
                copyRecentBtn.type = 'button';
                copyRecentBtn.className = 'chip-btn';
                copyRecentBtn.textContent = 'Copy';
                copyRecentBtn.onclick = async () => {
                    const copied = await copyText(item.url);
                    if (!copied) {
                        return;
                    }

                    const originalText = copyRecentBtn.textContent;
                    copyRecentBtn.textContent = 'Copied';
                    setTimeout(() => {
                        copyRecentBtn.textContent = originalText;
                    }, 1500);
                };

                actions.appendChild(openBtn);
                actions.appendChild(copyRecentBtn);

                row.appendChild(meta);
                row.appendChild(actions);
                recentLinksList.appendChild(row);
            });
        }

        function formatRecentLinkAge(savedAt) {
            const elapsedMs = Math.max(0, Date.now() - savedAt);
            const elapsedMinutes = Math.floor(elapsedMs / 60000);
            const remainingMinutes = Math.max(0, Math.ceil((storedLinkTtlMs - elapsedMs) / 60000));

            if (elapsedMinutes < 1) {
                return 'Saved just now';
            }

            if (elapsedMinutes < 60) {
                return `Saved ${elapsedMinutes}m ago • ${remainingMinutes}m left`;
            }

            return 'Saved less than 1h ago';
        }

        function showResultStage(url) {
            shareLinkInput.value = url;
            uploadStage.classList.add('hidden');
            progressStage.classList.add('hidden');
            resultStage.classList.remove('hidden');
            resultStage.style.animation = 'none';
            resultStage.offsetHeight;
            resultStage.style.animation = 'fadeSlideUp 0.5s ease forwards';
        }

        function restoreStoredLink() {
            const stored = getStoredLink();
            if (!stored) {
                return;
            }

            const recentLinks = getRecentLinks();
            if (!recentLinks.some((item) => item.url === stored.url)) {
                persistShareLink(stored.url, 'Recent shared file');
            }

            showResultStage(stored.url);
        }

        function resetUploader() {
            localStorage.removeItem(storedLinkKey);
            resultStage.classList.add('hidden');
            progressStage.classList.add('hidden');
            uploadStage.classList.remove('hidden');
            updateFilePreview(null);
            document.getElementById('password').value = '';
            document.getElementById('is_one_time').checked = false;
            shareLinkInput.value = '';
            progressBar.style.width = '0%';
            progressPercent.textContent = '0%';
            fileNameLabel.textContent = 'Connecting...';
        }

        function clearRecentLinks() {
            localStorage.removeItem(recentLinksKey);
            renderRecentLinks();
        }

        async function copyText(value) {
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(value);
                    return true;
                } catch (error) {
                    // Fall back to execCommand below.
                }
            }

            const originalValue = shareLinkInput.value;
            shareLinkInput.value = value;
            shareLinkInput.select();
            const copied = document.execCommand('copy');
            shareLinkInput.value = originalValue;
            return copied;
        }

        function handleUpload(file) {
            if (!file) return;

            uploadStage.classList.add('hidden');
            progressStage.classList.remove('hidden');
            fileNameLabel.textContent = file.name;

            const chunkSize = 1024 * 1024; // 1MB chunks
            const totalChunks = Math.ceil(file.size / chunkSize);
            const uuid = crypto.randomUUID();
            const password = document.getElementById('password').value;
            const isOneTime = document.getElementById('is_one_time').checked ? "1" : "0";

            uploadChunk(0);

            function uploadChunk(index) {
                const start = index * chunkSize;
                const end = Math.min(start + chunkSize, file.size);
                const chunk = file.slice(start, end);

                const formData = new FormData();
                formData.append('chunk', chunk);
                formData.append('index', index);
                formData.append('total_chunks', totalChunks);
                formData.append('uuid', uuid);
                formData.append('original_name', file.name);
                formData.append('password', password);
                formData.append('is_one_time', isOneTime);
                formData.append('_token', '{{ csrf_token() }}');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', `{{ route('upload') }}`, true);

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        const chunkPercent = (e.loaded / e.total);
                        const totalPercent = Math.round(((index + chunkPercent) / totalChunks) * 100);
                        progressBar.style.width = totalPercent + '%';
                        progressPercent.textContent = totalPercent + '%';
                    }
                };

                xhr.onload = () => {
                    const response = JSON.parse(xhr.responseText);
                    if (xhr.status === 200) {
                        if (response.done) {
                            persistShareLink(response.download_link, file.name);
                            showResultStage(response.download_link);
                        } else if (index + 1 < totalChunks) {
                            uploadChunk(index + 1);
                        } else {
                            // Safety fallback if server missed the 'done' flag
                            console.error("Upload reached end but server didn't confirm completion.");
                        }
                    } else {
                        alert(response.message || 'Upload failed. Please try again.');
                        window.location.reload();
                    }
                };

                xhr.onerror = (e) => {
                    console.log(e);
                    // alert('Network error occurred during upload.');
                    // window.location.reload();
                };

                xhr.send(formData);
            }
        }

        shareAnotherBtn.onclick = () => resetUploader();
        clearHistoryBtn.onclick = () => clearRecentLinks();
        themeToggle.onclick = () => {
            const currentTheme = document.documentElement.getAttribute('data-theme') || getSystemTheme();
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem(themeStorageKey, nextTheme);
            applyTheme(nextTheme);
        };

        copyBtn.onclick = async () => {
            const copied = await copyText(shareLinkInput.value);
            if (!copied) {
                return;
            }

            const originalText = copyBtn.textContent;
            copyBtn.textContent = 'Copied!';
            copyBtn.style.background = 'var(--success-gradient)';

            setTimeout(() => {
                copyBtn.textContent = originalText;
                copyBtn.style.background = '';
            }, 2000);
        };
    </script>
</body>

</html>

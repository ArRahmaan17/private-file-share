<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Download File - FileStream" description="Securely download shared files with encryption and self-destruct options." />
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
            --bg-card: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --text-primary: #f0f0f5;
            --text-secondary: #8f93a3;
            --text-muted: #525566;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.2);
            --red: #f87171;
            --amber-soft: rgba(251, 191, 36, 0.1);
            --amber: #fbbf24;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
        }

        /* Ambient Orbs */
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
            animation: breathe 20s ease-in-out infinite alternate;
        }

        .o1 {
            width: 500px;
            height: 500px;
            background: #6366f1;
            top: -10%;
            right: -10%;
            transform: translate(0, 0);
        }

        .o2 {
            width: 400px;
            height: 400px;
            background: #3b82f6;
            bottom: -20%;
            left: -10%;
            animation-delay: -5s;
        }

        @keyframes breathe {
            0% {
                transform: scale(1) translate(0, 0);
            }

            100% {
                transform: scale(1.1) translate(-30px, 30px);
            }
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Main Card */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(40px) saturate(1.5);
            -webkit-backdrop-filter: blur(40px) saturate(1.5);
            border: 1px solid var(--border);
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        }

        /* Hero Icon */
        .file-icon {
            width: 80px;
            height: 80px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(168, 85, 247, 0.15));
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 16px 40px var(--accent-glow);
        }

        .file-icon svg {
            width: 36px;
            height: 36px;
            color: #a5a6ff;
        }

        /* Meta */
        h1 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 8px;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .expiry {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: var(--amber-soft);
            color: var(--amber);
            border: 1px solid rgba(251, 191, 36, 0.15);
            margin-bottom: 32px;
        }

        /* Form */
        .form-wrap {
            text-align: left;
            margin-bottom: 24px;
        }

        .label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            padding-left: 4px;
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 20px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 15px;
            transition: all 0.2s;
            outline: none;
        }

        .input-field:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .input-field.is-invalid {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15);
        }

        .error-text {
            color: var(--red);
            font-size: 12px;
            margin-top: 8px;
            padding-left: 4px;
            font-weight: 500;
        }

        /* Button */
        .btn-dl {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 18px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 20px var(--accent-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: inherit;
        }

        .btn-dl:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.4);
        }

        .btn-dl svg {
            width: 20px;
            height: 20px;
        }

        /* Footer */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 32px;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: white;
        }
    </style>
</head>

<body>
    <div class="ambient">
        <div class="orb o1"></div>
        <div class="orb o2"></div>
    </div>

    <div class="container">
        <main class="glass-panel">
            <div class="file-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v6m-3-3h6" />
                </svg>
            </div>

            <h1 title="{{ $fileEntry->original_name }}">{{ $fileEntry->original_name }}</h1>
            <p class="expiry">Expires {{ $fileEntry->expires_at->diffForHumans() }}</p>

            @if($fileEntry->is_one_time)
            <div class="badge">Self-Destructs After Download</div>
            @endif

            <form action="{{ route('download', $fileEntry->slug) }}" method="POST">
                @csrf

                @if($fileEntry->password)
                <div class="form-wrap">
                    <label for="password" class="label">Password Required</label>
                    <input type="password" id="password" name="password" required
                        class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Enter password to decrypt">
                    @error('password')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <button type="submit" class="btn-dl">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download File
                </button>
            </form>
        </main>

        <a href="/" class="back-link">← Return to FileStream</a>
    </div>
</body>

</html>
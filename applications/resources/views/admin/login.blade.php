<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="Admin Login - FileStream" description="Secure access to the FileStream management dashboard." />
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
            --text-primary: #f0f0f5;
            --text-secondary: #6b6f80;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Ambient background */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .ambient-bg .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.4;
            animation: drift 20s ease-in-out infinite alternate;
        }

        .ambient-bg .orb-1 {
            width: 600px;
            height: 600px;
            background: #6366f1;
            top: -20%;
            left: -10%;
            animation-delay: 0s;
        }

        .ambient-bg .orb-2 {
            width: 500px;
            height: 500px;
            background: #a855f7;
            bottom: -20%;
            right: -10%;
            animation-delay: -5s;
        }

        .ambient-bg .orb-3 {
            width: 300px;
            height: 300px;
            background: #3b82f6;
            top: 40%;
            left: 50%;
            animation-delay: -10s;
        }

        @keyframes drift {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -20px) scale(1.1);
            }

            100% {
                transform: translate(-20px, 30px) scale(0.95);
            }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }

        .login-card {
            background: var(--bg-card);
            backdrop-filter: blur(40px) saturate(1.4);
            -webkit-backdrop-filter: blur(40px) saturate(1.4);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
        }

        .brand {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
        }

        .brand-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .brand h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #e0e0ff 0%, #a5a6ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand p {
            color: var(--text-secondary);
            font-size: 13px;
            margin-top: 6px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            margin-bottom: 8px;
            padding-left: 2px;
        }

        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.15);
        }

        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .error-msg {
            color: #f87171;
            font-size: 12px;
            margin-top: 8px;
            padding-left: 2px;
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 15px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 24px rgba(99, 102, 241, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.45);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 28px;
            color: var(--text-secondary);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--accent);
        }

        /* Entrance animation */
        .login-card {
            animation: cardEnter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(24px);
        }

        @keyframes cardEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="ambient-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand">
                <div class="brand-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1>FileStream Admin</h1>
                <p>Enter your password to continue</p>
            </div>

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="password" class="form-label">Admin Password</label>
                    <input type="password" id="password" name="password" required
                        class="form-input" placeholder="••••••••••" autofocus>
                    @error('password')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">Unlock Dashboard</button>
            </form>
        </div>
        <a href="/" class="back-link">← Back to FileStream</a>
    </div>
</body>

</html>
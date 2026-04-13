<!DOCTYPE html>
<html lang="en">

<head>
    <x-head title="FileStream - Simple, Secure File Sharing"
        description="High-performance, ephemeral file sharing with 1-hour expiration and password protection." />
    <style>*, *::before, *::after{ box-sizing: border-box; margin: 0; padding: 0;} :root{ --bg-primary: #08090d; --bg-card: rgba(255, 255, 255, 0.03); --bg-card-hover: rgba(255, 255, 255, 0.05); --border: rgba(255, 255, 255, 0.06); --border-hover: rgba(255, 255, 255, 0.12); --text-primary: #f0f0f5; --text-secondary: #8f93a3; --text-muted: #525566; --accent: #6366f1; --accent-glow: rgba(99, 102, 241, 0.2); --success: #34d399; --success-glow: rgba(52, 211, 153, 0.2);} body{ font-family: 'Inter', system-ui, sans-serif; background: var(--bg-primary); color: var(--text-primary); min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; -webkit-font-smoothing: antialiased;} .ambient{ position: fixed; inset: 0; z-index: 0; pointer-events: none;} .orb{ position: absolute; border-radius: 50%; filter: blur(140px); opacity: 0.35; animation: breathe 25s ease-in-out infinite alternate;} .o1{ width: 600px; height: 600px; background: #6366f1; top: -20%; left: -10%;} .o2{ width: 500px; height: 500px; background: #a855f7; bottom: -20%; right: -10%; animation-delay: -5s;} .o3{ width: 400px; height: 400px; background: #3b82f6; top: 40%; left: 50%; animation-delay: -10s; transform: translate(-50%, -50%);} @keyframes breathe{ 0%{ transform: scale(1) translate(0, 0);} 100%{ transform: scale(1.1) translate(30px, -30px);}} .container{ position: relative; z-index: 1; width: 100%; max-width: 640px; margin: auto; padding: 40px 24px; display: flex; flex-direction: column; gap: 40px;} header{ text-align: center;} .logo-wrap{ display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 20px; background: linear-gradient(135deg, #6366f1, #a855f7); box-shadow: 0 12px 32px var(--accent-glow); margin-bottom: 24px;} .logo-wrap svg{ width: 32px; height: 32px; color: white;} h1{ font-size: 42px; font-weight: 800; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 12px; background: linear-gradient(135deg, #fff 0%, #a5a6ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;} .subtitle{ font-size: 16px; color: var(--text-secondary); font-weight: 400;} .glass-panel{ background: var(--bg-card); backdrop-filter: blur(40px) saturate(1.5); -webkit-backdrop-filter: blur(40px) saturate(1.5); border: 1px solid var(--border); border-radius: 32px; padding: 40px; box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4); position: relative; overflow: hidden;} .glass-panel::before{ content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);} .drop-zone{ border: 2px dashed var(--border-hover); border-radius: 24px; padding: 48px 24px; text-align: center; cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); background: rgba(255, 255, 255, 0.01); margin-bottom: 32px;} .drop-zone:hover, .drop-zone.active{ border-color: var(--accent); background: var(--accent-glow);} .drop-icon{ width: 56px; height: 56px; margin: 0 auto 16px; border-radius: 16px; background: var(--bg-card-hover); display: flex; align-items: center; justify-content: center; color: var(--accent); transition: transform 0.3s;} .drop-zone:hover .drop-icon{ transform: translateY(-4px); background: white;} .drop-zone:hover .drop-icon svg{ color: var(--accent);} .drop-title{ font-size: 18px; font-weight: 600; margin-bottom: 6px;} .drop-desc{ font-size: 13px; color: var(--text-secondary);} .options-grid{ display: grid; grid-template-columns: 1fr 1fr; gap: 24px;} @media (max-width: 500px){ .options-grid{ grid-template-columns: 1fr;}} .form-group{ display: flex; flex-direction: column; gap: 8px;} .label{ font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-secondary); padding-left: 4px;} .input-field{ background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 14px; padding: 14px 16px; color: var(--text-primary); font-family: inherit; font-size: 14px; transition: all 0.2s; outline: none;} .input-field:focus{ border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow);} .input-field::placeholder{ color: var(--text-muted);} .toggle-wrap{ display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; border-radius: 14px; background: rgba(255, 255, 255, 0.02); border: 1px solid transparent; cursor: pointer; transition: all 0.2s;} .toggle-wrap:hover{ background: rgba(255, 255, 255, 0.04); border-color: var(--border);} .toggle-switch{ width: 36px; height: 20px; border-radius: 20px; background: var(--border-hover); position: relative; flex-shrink: 0; transition: background 0.3s; margin-top: 2px;} .toggle-knob{ width: 14px; height: 14px; background: white; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);} input[type="checkbox"]{ display: none;} input[type="checkbox"]:checked+.toggle-wrap .toggle-switch{ background: var(--accent); box-shadow: 0 0 12px var(--accent-glow);} input[type="checkbox"]:checked+.toggle-wrap .toggle-knob{ transform: translateX(16px);} .toggle-text{ display: flex; flex-direction: column; gap: 2px;} .toggle-title{ font-size: 13px; font-weight: 600; color: var(--text-primary);} .toggle-desc{ font-size: 11px; color: var(--text-secondary);} .progress-box{ text-align: center; padding: 24px 0;} .progress-meta{ display: flex; justify-content: space-between; font-size: 13px; font-weight: 500; margin-bottom: 12px;} .progress-name{ color: var(--text-primary); max-width: 70%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;} .progress-pct{ color: var(--accent); font-variant-numeric: tabular-nums;} .progress-track{ width: 100%; height: 8px; background: rgba(255, 255, 255, 0.08); border-radius: 100px; overflow: hidden;} .progress-fill{ height: 100%; background: linear-gradient(90deg, #6366f1, #a855f7); border-radius: 100px; width: 0%; transition: width 0.1s linear;} .success-icon{ width: 64px; height: 64px; border-radius: 50%; background: var(--success-glow); color: var(--success); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;} .success-icon svg{ width: 32px; height: 32px;} .result-title{ font-size: 20px; font-weight: 700; margin-bottom: 24px; text-align: center;} .link-copier{ display: flex; flex-direction: column; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;} .link-input{ flex: 1; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border); border-radius: 14px; padding: 16px; color: var(--text-primary); font-size: 14px; outline: none; font-family: inherit; read-only: true;} .btn-primary{ background: linear-gradient(135deg, #6366f1, #7c3aed); color: white; border: none; border-radius: 14px; padding: 16px 24px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; white-space: nowrap; box-shadow: 0 4px 20px var(--accent-glow);} .btn-primary:hover{ transform: translateY(-2px); box-shadow: 0 8px 28px rgba(99, 102, 241, 0.4);} .btn-secondary{ background: transparent; border: 1px solid var(--border-hover); color: var(--text-primary); border-radius: 14px; padding: 16px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%;} .btn-secondary:hover{ background: var(--bg-card-hover); border-color: var(--border);} .hidden{ display: none !important;} .animate-enter{ animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0;} @keyframes fadeSlideUp{ from{ opacity: 0; transform: translateY(20px);} to{ opacity: 1; transform: translateY(0);}} footer{ text-align: center; font-size: 13px; color: var(--text-secondary); font-weight: 400; padding: 40px 0 20px; display: flex; flex-direction: column; gap: 16px; opacity: 0.8;} .footer-stats{ display: flex; align-items: center; justify-content: center; gap: 24px; padding: 12px 24px; background: rgba(255, 255, 255, 0.03); border-radius: 100px; width: fit-content; margin: 0 auto; border: 1px solid var(--border);} .stat-item{ display: flex; align-items: center; gap: 8px;} .stat-dot{ width: 6px; height: 6px; border-radius: 50%; background: var(--accent); box-shadow: 0 0 8px var(--accent);} .stat-value{ font-weight: 700; color: var(--text-primary);} .stat-label{ font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;} </style>
</head>

<body>
    <div class="ambient">
        <div class="orb o1"></div>
        <div class="orb o2"></div>
        <div class="orb o3"></div>
    </div>

    <div class="container animate-enter">
        <header>
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
                    <div class="drop-desc">or click to browse (Max 110MB)</div>
                    <input type="file" id="file-input" class="hidden"
                        accept=".pdf,.zip,.rar,.7z,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt,.csv,.mp4,.mp3">
                </div>

                <!-- Selected File Preview (Hidden by default) -->
                <div id="file-preview-wrap" class="hidden"
                    style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 20px; margin-bottom: 32px; transition: all 0.3s ease;">
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
                        onmouseover="this.style.color='var(--red)'; this.style.background='var(--bg-card-hover)'"
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

                <button onclick="window.location.reload()" class="btn-secondary">Share another file</button>
            </div>
        </main>

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

        let selectedFile = null;

        dropZone.onclick = () => fileInput.click();

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

            if (file.size > 110 * 1024 * 1024) {
                alert('File is too large (Max 110MB).');
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
            if (size >= 1048576) {
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
                xhr.open('POST', '{{ route('upload') }}', true);

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
                            shareLinkInput.value = response.download_link;
                            progressStage.classList.add('hidden');
                            resultStage.classList.remove('hidden');
                            resultStage.style.animation = 'none';
                            resultStage.offsetHeight;
                            resultStage.style.animation = 'fadeSlideUp 0.5s ease forwards';
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

                xhr.onerror = () => {
                    alert('Network error occurred during upload.');
                    window.location.reload();
                };

                xhr.send(formData);
            }
        }

        copyBtn.onclick = () => {
            shareLinkInput.select();
            document.execCommand('copy');
            const originalText = copyBtn.textContent;
            copyBtn.textContent = 'Copied!';
            copyBtn.style.background = 'linear-gradient(135deg, #34d399, #059669)';

            setTimeout(() => {
                copyBtn.textContent = originalText;
                copyBtn.style.background = '';
            }, 2000);
        };
    </script>
</body>

</html>

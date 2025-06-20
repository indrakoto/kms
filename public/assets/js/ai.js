// Variabel global
let selectedApi = 'alphabyte';
const apiUrls = {
    alphabyte: '/ai-api',
    chat: '/chat-api',
    pusdatin: '/pusdatin-api'
};

// Variabel global
let isSending = false;

// Inisialisasi saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    initializeScrollAnchor();
    setupApiSelector();
    setupEventListeners();
    updateSendButton();
});

// Setup semua event listeners
// Setup event listeners yang sederhana dan efektif
function setupEventListeners() {
    const input = document.getElementById('user-input');
    const sendButton = document.querySelector('.send-btn');
    
    // 1. Handle klik tombol kirim
    sendButton.addEventListener('click', handleSendMessage);
    
    // 2. Handle tekan Enter
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSendMessage();
        }
    });
    
    // 3. Update tombol saat input berubah
    input.addEventListener('input', function() {
        updateSendButton();
        autoResizeTextarea(this);
    });
}

// Fungsi untuk mengatur state tombol kirim
function updateSendButton() {
    const input = document.getElementById('user-input');
    const sendButton = document.querySelector('.send-btn');
    const hasText = input.value.trim().length > 0;
    
    if (isSending) {
        sendButton.disabled = true;
        sendButton.classList.add('inactive');
        return;
    }
    
    if (hasText) {
        sendButton.disabled = false;
        sendButton.classList.remove('inactive');
    } else {
        sendButton.disabled = true;
        sendButton.classList.add('inactive');
    }
}

// Auto-resize textarea
function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

// Setup API selector
function setupApiSelector() {
    const apiOptions = document.querySelectorAll('.api-option');
    
    apiOptions.forEach(option => {
        option.addEventListener('click', function() {
            apiOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            selectedApi = this.dataset.api;
        });
    });
}

// Fungsi scroll
function initializeScrollAnchor() {
    const chatBox = document.getElementById('chat-box');
    if (!chatBox.querySelector('#scroll-anchor')) {
        const anchor = document.createElement('div');
        anchor.id = 'scroll-anchor';
        chatBox.appendChild(anchor);
    }
}

function updateScrollAnchor() {
    const chatBox = document.getElementById('chat-box');
    let anchor = document.getElementById('scroll-anchor');
    
    if (!anchor) {
        anchor = document.createElement('div');
        anchor.id = 'scroll-anchor';
    }
    
    chatBox.appendChild(anchor);
}

function scrollToBottom() {
    const chatBox = document.getElementById('chat-box');
    const anchor = document.getElementById('scroll-anchor');
    
    if (anchor) {
        // Gunakan scrollTop untuk scroll internal element
        chatBox.scrollTop = chatBox.scrollHeight;
        
        // Optional: Smooth scroll dengan animation
        smoothScroll(chatBox, chatBox.scrollHeight, 300);
    }
}

// Helper function untuk smooth scroll
function smoothScroll(element, target, duration) {
    const start = element.scrollTop;
    const change = target - start;
    const startTime = performance.now();
    
    function animateScroll(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        element.scrollTop = start + change * progress;
        
        if (progress < 1) {
            requestAnimationFrame(animateScroll);
        }
    }
    
    requestAnimationFrame(animateScroll);
}

// Fungsi scroll ke elemen tertentu dalam chat box
function scrollToElement(element) {
    const chatBox = document.getElementById('chat-box');
    const elementPosition = element.offsetTop;
    const chatBoxHeight = chatBox.clientHeight;
    const scrollTo = elementPosition - (chatBoxHeight / 3); // Scroll ke 1/3 atas elemen
    
    chatBox.scrollTo({
        top: scrollTo,
        behavior: 'smooth'
    });
}

function cleanHtmlText(text) {
    // Ganti semua <p ...> dan </p> dengan newline
    text = text.replace(/<p[^>]*>/gi, '\n');
    text = text.replace(/<\/p>/gi, '\n');

    // Ganti <br> dan <br/> dengan newline
    text = text.replace(/<br\s*\/?>/gi, '\n');

    // Hapus tag HTML lainnya (opsional)
    text = text.replace(/<[^>]+>/g, '');

    // Ubah multiple newline menjadi satu saja
    text = text.replace(/\n{2,}/g, '\n');

    // Trim spasi dan newline di awal/akhir
    return text.trim();
}

function cleanTagP(text) {
    // Ganti semua <p ...> menjadi \n
    text = text.replace(/<p[^>]*>/gi, '\n');
    // Ganti semua </p> menjadi \n
    text = text.replace(/<\/p>/gi, '\n');
    return text;
}


// Fungsi untuk mengubah URL menjadi link
function urlToLinkOLD(text) {
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, url => {
        return `<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`;
    });
}
function urlToLinkOLD2(text) {
    const urlRegex = /(https?:\/\/[^\s<>"'`{}|\\^\[\]]+)/g;

    return text.replace(urlRegex, match => {
        // Jangan proses jika URL mengandung spasi
        if (/\s/.test(match)) {
            return match;
        }

        // Pisahkan tanda baca di akhir URL
        const matchUrl = match.match(/^(https?:\/\/[^\s<>"'`{}|\\^\[\]]*?)([.,!?)]*?)$/);

        if (matchUrl) {
            const cleanUrl = matchUrl[1];
            const trailingPunctuation = matchUrl[2];
            return `<a href="${cleanUrl}" target="_blank" rel="noopener noreferrer">${cleanUrl}</a>${trailingPunctuation}`;
        }

        return match;
    });
}

function urlToLink(text) {
    // 1. Ganti <p> dan </p> jadi newline
    text = text.replace(/<p[^>]*>/gi, '\n');
    text = text.replace(/<\/p>/gi, '\n');

    // 2. Ganti URL menjadi <a href="...">...</a>
    const urlRegex = /(https?:\/\/[^\s<>"'`{}|\\^\[\]]+)/g;

    text = text.replace(urlRegex, match => {
        // Abaikan URL yang mengandung spasi
        if (/\s/.test(match)) {
            return match;
        }

        // Pisahkan tanda baca di akhir
        const parts = match.match(/^(.*?)([.,!?)]*?)$/);
        const url = parts[1];
        const trailing = parts[2];

        return `<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>${trailing}`;
    });

    return text;
}





// Konversi markdown table ke HTML
function markdownTableToHtml(markdownTable) {
    const lines = markdownTable.trim().split('\n');
    
    const headerParts = lines[0].split('|').map(part => part.trim());
    const headers = headerParts.slice(1, -1); 

    const separatorParts = lines[1].split('|').map(part => part.trim());
    const actualColumnCount = separatorParts.slice(1, -1).length;

    const rows = lines.slice(2)
        .filter(line => line.includes('|'))
        .map(line => {
            const parts = line.split('|').map(part => part.trim());
            return parts.slice(1, 1 + actualColumnCount); 
        });

    let html = '<div class="table-container"><table class="bot-table">';
    
    html += '<thead><tr>';
    headers.slice(0, actualColumnCount).forEach(header => {
        html += `<th>${header}</th>`;
    });
    html += '</tr></thead>';
    
    html += '<tbody>';
    rows.forEach(row => {
        html += '<tr>';
        row.forEach(cell => {
            html += `<td>${urlToLink(cell)}</td>`;
        });
        html += '</tr>';
    });
    html += '</tbody></table></div>';
    
    return html;
}

// Proses respon dari bot
function processBotResponse(responseText) {
    const lines = responseText.split('\n');
    let html = '';
    let tableLines = [];
    let inTable = false;

    lines.forEach(line => {
        if (line.trim().startsWith('|') && line.includes('|')) {
            if (!inTable) inTable = true;
            tableLines.push(line);
        } else {
            if (inTable) {
                html += markdownTableToHtml(tableLines.join('\n'));
                tableLines = [];
                inTable = false;
            }
            if (line.trim()) {
                html += `<div class="message-text">${urlToLink(line)}</div>`;
            }
        }
    });

    if (inTable) {
        html += markdownTableToHtml(tableLines.join('\n'));
    }

    return html;
}

// Fungsi utama untuk mengirim pesan
async function handleSendMessage() {
    if (isSending) return;
    
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');
    const sendButton = document.querySelector('.send-btn');
    const message = input.value.trim();
    
    if (!message || sendButton.disabled) return;
    
    isSending = true;
    updateSendButton();
    
    try {
        // Tampilkan pesan pengguna
        //chatBox.innerHTML += `<div class="message user">${message}</div>`;
        // 1. Tampilkan pesan pengguna
        const userMessageElement = document.createElement('div');
        userMessageElement.className = 'message user';
        userMessageElement.textContent = message;
        chatBox.appendChild(userMessageElement);

        // Scroll ke pesan pengguna terlebih dahulu
        scrollToElement(userMessageElement);

        input.value = '';
        
        // Tampilkan loading
        sendButton.innerHTML = `<div class="spinner"></div>`;
        
        // Kirim ke API
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(apiUrls[selectedApi], {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json' // Explicitly request JSON
            },
            body: JSON.stringify({ message: message })
        });
        
        // Periksa content-type response
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error(`Response bukan JSON. Content-Type: ${contentType}`);
        }
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || `HTTP error! Status: ${response.status}`);
        }
        
        // Tampilkan response
        //chatBox.innerHTML += `<div class="message bot">${processBotResponse(data.response)}</div>`;
        //updateScrollAnchor();
        const botMessageElement = document.createElement('div');
        botMessageElement.className = 'message bot';
        botMessageElement.innerHTML = processBotResponse(data.response);
        chatBox.appendChild(botMessageElement);
        
        // Scroll ke bawah dengan delay kecil
        setTimeout(() => {
            scrollToElement(botMessageElement);
            updateScrollAnchor();
        }, 50);
        
    } catch (error) {
        console.error('Error:', error);
        
        let errorMessage = 'Terjadi kesalahan saat memproses permintaan';
        if (error.message.includes('JSON') || error.message.includes('<!DOCTYPE')) {
            errorMessage = 'Server mengembalikan respons tidak valid (bukan JSON)';
        } else if (error.message.includes('Failed to fetch')) {
            errorMessage = 'Tidak dapat terhubung ke server';
        }
        
        const errorElement = document.createElement('div');
        errorElement.className = 'message bot error';
        errorElement.innerHTML = `
            ${errorMessage}<br>
            <small>${selectedApi === 'internal' ? 'API Internal' : 'API alphabyte'}</small>
        `;
        chatBox.appendChild(errorElement);

        //setTimeout(scrollToBottom, 50);
        setTimeout(() => {
            scrollToElement(errorElement);
            updateScrollAnchor();
        }, 50);

    } finally {
        isSending = false;
        sendButton.innerHTML = `<i class="fas fa-paper-plane"></i>`;
        updateSendButton();
        //scrollToBottom();
    }
}
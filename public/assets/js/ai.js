// Fungsi untuk mengubah URL menjadi link
const urlToLink = (text) => {
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, url => {
        return `<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`;
    });
};

// Fungsi untuk memproses respon dari bot
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

    return `<div class="message bot">${html}</div>`;
}

// Fungsi khusus untuk konversi markdown table ke HTML
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
            html += `<td>${cell}</td>`;
        });
        html += '</tr>';
    });
    html += '</tbody></table></div>';
    
    return html;
}

// Fungsi untuk mengirim pesan
async function sendMessage() {
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');
    const sendButton = document.querySelector('.send-btn'); // class-based
    const userMessage = input.value.trim();
    if (!userMessage) return;

    chatBox.innerHTML += `<div class="message user">${userMessage}</div>`;
    input.value = '';
    //sendButton.style.display = 'none'; // Sembunyikan tombol setelah kirim
    //sendButton.disabled = true;
    //sendButton.innerHTML = 'Sedang Proses...';
     // Ubah ke loading spinner
    sendButton.classList.add('loading');
    sendButton.innerHTML = `<div class="spinner"></div>`;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch('/ai-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ message: userMessage }),
        });

        if (!response.ok) {
            throw new Error(`Kesalahan HTTP! Status: ${response.status}`);
        }

        const data = await response.json();
        const botMessage = data.response || "Tidak ada balasan";

        chatBox.innerHTML += processBotResponse(botMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

    } catch (error) {
        console.error("Terjadi kesalahan:", error);
        chatBox.innerHTML += `<div class="message bot">Terjadi kesalahan, coba lagi nanti.</div>`;
        //chatBox.scrollTop = chatBox.scrollHeight;
    } finally {
        sendButton.disabled = false;
        //sendButton.innerHTML = 'Kirim';
         // Kembalikan ke ikon panah
        sendButton.classList.remove('loading');
        sendButton.innerHTML = `<i class="fas fa-paper-plane"></i>`;
    }
}

// Kirim saat tombol diklik
document.querySelector('.send-btn').addEventListener('click', sendMessage);

// Kirim saat tekan Enter (tanpa shift)
document.getElementById('user-input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
});

// Munculkan tombol kirim jika ada input
document.getElementById('user-input').addEventListener('input', function () {
    const sendButton = document.querySelector('.send-btn');
    if (this.value.trim().length > 0) {
        sendButton.style.display = 'block';
    } else {
        sendButton.style.display = 'none';
    }
});

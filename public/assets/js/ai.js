// Fungsi untuk mengubah URL menjadi link
const urlToLink = (text) => {
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, url => {
        return `<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`;
    });
};

// Fungsi untuk memproses respons dari bot
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
    const userMessage = input.value.trim();
    if (!userMessage) return; // Jangan kirim jika input kosong

    // Tampilkan pesan pengguna di UI
    chatBox.innerHTML += `<div class="message user">${userMessage}</div>`;
    input.value = ''; // Bersihkan input

    // Tampilkan animasi loading
    chatBox.innerHTML += `<div id="loading" class="message bot">Mengirim...</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        // Kirim pesan ke API
        const response = await fetch('/ai-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                message: userMessage
            }),
        });

        if (!response.ok) {
            throw new Error(`Kesalahan HTTP! Status: ${response.status}`);
        }

        const data = await response.json();
        const botMessage = data.response || "Tidak ada balasan";

        // Proses respon bot dan hapus animasi loading
        document.getElementById('loading').remove();
        chatBox.innerHTML += processBotResponse(botMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

    } catch (error) {
        console.error("Terjadi kesalahan:", error);
        document.getElementById('loading').remove();
        chatBox.innerHTML += `<div class="message bot">Terjadi kesalahan, coba lagi nanti.</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

// Kirim pesan saat tombol "Kirim" diklik
document.getElementById('send-btn').addEventListener('click', sendMessage);

// Kirim pesan saat menekan tombol Enter
document.getElementById('user-input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();  // Mencegah pengiriman form
        sendMessage();
    }
});

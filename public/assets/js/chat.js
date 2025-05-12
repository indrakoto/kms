// Fungsi untuk memproses response bot (teks + tabel)
function processBotResponse(responseText) {
    // Pisahkan setiap baris dan filter yang kosong
    const lines = responseText.split('\n').filter(line => line.trim() !== '');
    let htmlOutput = '';
    let currentTableLines = [];
    let inTable = false;

    lines.forEach(line => {
        // Deteksi awal tabel
        if (line.trim().startsWith('|') && line.includes('|')) {
            if (!inTable) {
                // Mulai tabel baru
                inTable = true;
                currentTableLines = [];
            }
            currentTableLines.push(line);
        } else {
            // Jika sedang dalam tabel, proses tabel terlebih dahulu
            if (inTable && currentTableLines.length > 0) {
                htmlOutput += markdownTableToHtml(currentTableLines.join('\n'));
                currentTableLines = [];
                inTable = false;
            }
            // Tambahkan teks biasa
            if (line.trim()) {
                htmlOutput += `<div class="message-text">${line}</div>`;
            }
        }
    });

    // Handle tabel di akhir teks
    if (inTable && currentTableLines.length > 0) {
        htmlOutput += markdownTableToHtml(currentTableLines.join('\n'));
    }

    return `<div class="message bot">${htmlOutput}</div>`;
}

// Fungsi khusus untuk konversi markdown table ke HTML
function markdownTableToHtml(markdownTable) {
    const lines = markdownTable.trim().split('\n');
    
    // Baris header (pertama)
    const headerParts = lines[0].split('|').map(part => part.trim());
    const headers = headerParts.slice(1, -1); // Hilangkan bagian kosong di awal/akhir
    
    // Baris separator (kedua) untuk menentukan jumlah kolom sebenarnya
    const separatorParts = lines[1].split('|').map(part => part.trim());
    const actualColumnCount = separatorParts.slice(1, -1).length;
    
    // Baris data (mulai dari baris ke-3)
    const rows = lines.slice(2)
        .filter(line => line.includes('|'))
        .map(line => {
            const parts = line.split('|').map(part => part.trim());
            return parts.slice(1, 1 + actualColumnCount); // Ambil hanya kolom yang sesuai
        });

    // Bangun HTML tabel
    let html = '<div class="table-container"><table class="bot-table">';
    
    // Header tabel
    html += '<thead><tr>';
    headers.slice(0, actualColumnCount).forEach(header => {
        html += `<th>${header}</th>`;
    });
    html += '</tr></thead>';
    
    // Body tabel
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

// Fungsi utama yang ada (dengan perbaikan)
document.getElementById('send-btn').addEventListener('click', async function () {
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');

    const userMessage = input.value.trim();
    if (!userMessage) return;

    // Tampilkan pesan pengguna
    chatBox.innerHTML += `<div class="message user">${userMessage}</div>`;
    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch('/chat-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                model: "llama3.2",
                prompt: userMessage,
                stream: false
            }),
        });

        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const data = await response.json();
        console.log("Raw response:", data);

        // Proses response dengan fungsi baru
        const botMessage = data.response || "Tidak ada balasan";
        chatBox.innerHTML += processBotResponse(botMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

    } catch (error) {
        console.error("Error:", error);
        chatBox.innerHTML += `<div class="message bot">Terjadi kesalahan: ${error.message}</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});
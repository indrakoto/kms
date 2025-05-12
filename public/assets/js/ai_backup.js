// Fungsi untuk mengubah teks tabel menjadi HTML tabel
function textToHtmlTable(textData) {
    // Pisahkan baris-baris data
    const lines = textData.split('\n').filter(line => line.trim() !== '');
    
    // Cari baris yang mengandung header tabel (yang mengandung | --- |)
    const headerSeparatorIndex = lines.findIndex(line => line.includes('|---'));
    
    // Jika format tabel tidak valid
    if (headerSeparatorIndex === -1 || headerSeparatorIndex === 0) {
        return textData; // Kembalikan teks asli jika bukan tabel
    }
    
    // Ambil header
    const headerLine = lines[headerSeparatorIndex - 1];
    const headers = headerLine.split('|').slice(1, -1).map(h => h.trim());
    
    // Ambil data baris
    const dataRows = lines.slice(headerSeparatorIndex + 1).filter(row => row.includes('|'));
    
    // Bangun HTML tabel
    let html = '<div class="table-container"><table class="bot-table">\n';
    
    // Tambahkan header
    html += '  <thead>\n    <tr>\n';
    headers.forEach(header => {
        html += `      <th>${header}</th>\n`;
    });
    html += '    </tr>\n  </thead>\n';
    
    // Tambahkan body
    html += '  <tbody>\n';
    dataRows.forEach(row => {
        const cells = row.split('|').slice(1, -1).map(c => c.trim());
        html += '    <tr>\n';
        cells.forEach(cell => {
            html += `      <td>${cell}</td>\n`;
        });
        html += '    </tr>\n';
    });
    html += '  </tbody>\n';
    
    html += '</table></div>';
    
    return html;
}

// Ketika tombol "Kirim" diklik
document.getElementById('send-btn').addEventListener('click', async function () {
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');

    const userMessage = input.value.trim();
    if (!userMessage) return; // Jangan kirim jika input kosong

    // Tampilkan pesan pengguna di UI
    chatBox.innerHTML += `<div class="message user">${userMessage}</div>`;
    input.value = ''; // Bersihkan input

    // Scroll ke bawah chat box
    chatBox.scrollTop = chatBox.scrollHeight;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        // Kirim pertanyaan ke API Ollama
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
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        console.log(data);  // Tambahkan log untuk melihat respons API

        // Proses respons untuk mengubah tabel teks menjadi HTML
        let botMessage = data.response || "Tidak ada balasan";
        
        // Cek jika respons mengandung format tabel
        if (botMessage.includes('|---') && botMessage.includes('|')) {
            botMessage = textToHtmlTable(botMessage);
        }
        
        // Tampilkan pesan bot
        chatBox.innerHTML += `<div class="message bot">${botMessage}</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

    } catch (error) {
        console.error("Terjadi kesalahan:", error);
        chatBox.innerHTML += `<div class="message bot">Terjadi kesalahan, coba lagi nanti.</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});
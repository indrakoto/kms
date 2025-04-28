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
            const response = await fetch('/proxy-chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Menyertakan CSRF token di header
                },
                body: JSON.stringify({
                    model: "gemma:7b-instruct",
                    prompt: userMessage,
                    stream: false
                }),
            });

            // Cek status response
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            // Parse response JSON
            const data = await response.json();
            console.log(data);  // Tambahkan log untuk melihat respons API

            // Ambil teks dari response dan tampilkan di UI
            const botMessage = data.response || "Tidak ada balasan";
            chatBox.innerHTML += `<div class="message bot">${botMessage}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;

        } catch (error) {
            console.error("Terjadi kesalahan:", error);
            chatBox.innerHTML += `<div class="message bot">Terjadi kesalahan, coba lagi nanti.</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
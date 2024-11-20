// Funkcja tworząca deszcz emotek ognia
function createFire() {
    const emoji = '🔥'; // Ognista emotka
    const fireEmoji = document.createElement('div');
    fireEmoji.classList.add('emoji');
    fireEmoji.textContent = emoji;
    fireEmoji.style.left = Math.random() * 100 + 'vw';  // Losowa pozycja na osi X
    fireEmoji.style.fontSize = Math.random() * 24 + 24 + 'px';  // Losowa wielkość emotki
    fireEmoji.style.animationDuration = Math.random() * 3 + 2 + 's';  // Losowy czas trwania animacji
    fireEmoji.style.position = 'absolute';  // Ustawienie pozycji absolutnej dla animacji

    // Dodanie animowanej emotki do tła
    document.body.appendChild(fireEmoji);

    // Usuwanie emotki po zakończeniu animacji (10 sekund)
    setTimeout(() => {
        fireEmoji.remove();
    }, 10000);
}

// Tworzenie deszczu ognia co 100ms
const fireInterval = setInterval(createFire, 100);

// Zatrzymanie interwału po 10 sekundach
setTimeout(() => {
    clearInterval(fireInterval); // Zatrzymanie deszczu ognia
}, 10000);

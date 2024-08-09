document.getElementById('registrationForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const fullName = document.getElementById('fullName').value;
    const nationality = document.getElementById('nationality').value;
    const countryOfResidence = document.getElementById('countryOfResidence').value;
    const dob = document.getElementById('dob').value;
    const email = document.getElementById('email').value;
    const idPhoto = document.getElementById('idPhoto').files[0];
    const organisation = document.getElementById('organisation').value;
    const position = document.getElementById('position').value;
    const events = document.getElementById('events').value;

    // Data object to generate QR code
    const data = {
        fullName,
        nationality,
        countryOfResidence,
        dob,
        email,
        organisation,
        position,
        events
    };

    const qrcodeContainer = document.getElementById('qrcode');
    qrcodeContainer.innerHTML = '';

    const qrCode = new QRCode(qrcodeContainer, {
        text: JSON.stringify(data),
        width: 128,
        height: 128
    });
});

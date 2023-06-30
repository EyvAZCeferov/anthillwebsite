function connectecho() {
    try {
        window.Echo.private('chats').listen('NewChatMessages', (e) => {
            console.log("Event dinlendi:");
            // axios.post('/notreadedmessages').then(response => {
            //     if (response != null) {
            //         var profil_section_on_header = document.getElementById('profil_section_on_header');
            //         var spanElement = document.createElement('span');
            //         spanElement.className = "badge";
            //         spanElement.style.position = "absolute";
            //         spanElement.style.top = "0";
            //         spanElement.style.right = "0";
            //         spanElement.style.backgroundColor = "red";
            //         spanElement.style.borderRadius = "50%";
            //         spanElement.style.width = "25px";
            //         spanElement.style.height = "25px";
            //         spanElement.style.display = "inline-block";
            //         spanElement.style.fontSize = "18px";
            //         spanElement.style.textAlign = "center";
            //         spanElement.style.color = "#fff";
            //         spanElement.innerHTML = parsedResponse;

            //         // Remove any existing <span> elements with the class 'badge'
            //         var existingSpans = profil_section_on_header.getElementsByClassName('badge');
            //         for (var i = 0; i < existingSpans.length; i++) {
            //             existingSpans[i].remove();
            //         }

            //         // Append the new <span> element to the 'profil_section_on_header' element
            //         profil_section_on_header.appendChild(spanElement);
            //     }
            // }).catch(error => console.log(error));
        });
    } catch (error) {
        console.log("Hata oluştu: ", error);
    }
}

export { connectecho };

// * * * * * cd /var/www/anthill/Website && php artisan queue:work >> /dev/null 2>&1

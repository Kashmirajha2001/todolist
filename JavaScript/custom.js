document.addEventListener('DOMContentLoaded', function () {
    const contentVoiceButton = document.getElementById('contentVoiceButton');
    const contentInput = document.getElementById('content');

    let recognition;
    
    contentVoiceButton.addEventListener('click', function () {
        if (!recognition || recognition.ended) {
            startVoiceRecognition(contentInput);
            showAlert('Recording for list content...');
        } else {
            recognition.stop();
            showAlert('Recording stopped.');
        }
    });

    function startVoiceRecognition(inputElement) {
        recognition = new webkitSpeechRecognition() || new SpeechRecognition();
        recognition.lang = window.navigator.language;

        recognition.onresult = function (event) {
            const spokenText = event.results[0][0].transcript;
            inputElement.value = spokenText;
        };

        recognition.onerror = function (event) {
            console.error('Voice recognition error:', event.error);
        };

        recognition.onend = function () {
            recognition.ended = true;
        };

        recognition.start();
    }

    function showAlert(message) {
        alert(message);
    }
});

document.getElementById('shareButton').addEventListener('click', function() {
    var table = document.getElementById('myTable');
    var tableText = '';

    for (var i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        tableText += row.cells[0].innerText + '.\t' + row.cells[1].innerText + '\n';
    }

    if (navigator.share) {
        navigator.share({
            text: tableText,
        })
        .then(() => console.log('Table shared successfully'))
        .catch(error => console.error('Error sharing:', error));
    } else {
        console.log('Web Share API not supported.');
    }
});
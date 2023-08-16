document.addEventListener('DOMContentLoaded', function () {
    const titleVoiceButton = document.getElementById('titleVoiceButton');
    const contentVoiceButton = document.getElementById('contentVoiceButton');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');

    let recognition;

    titleVoiceButton.addEventListener('click', function () {
        if (!recognition || recognition.ended) {
            startVoiceRecognition(titleInput);
            showAlert('Recording for Title...');
        } else {
            recognition.stop();
            showAlert('Recording stopped.');
        }
    });

    contentVoiceButton.addEventListener('click', function () {
        if (!recognition || recognition.ended) {
            startVoiceRecognition(contentInput);
            showAlert('Recording for Content...');
        } else {
            recognition.stop();
            showAlert('Recording stopped.');
        }
    });

    function startVoiceRecognition(inputElement) {
        recognition = new webkitSpeechRecognition() || new SpeechRecognition();
        recognition.lang = window.navigator.language; // Automatic language detection

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

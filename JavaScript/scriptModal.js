document.addEventListener('DOMContentLoaded', function () {
    const titleEditVoiceButton = document.getElementById('titleEditVoiceButton');
    const contentEditVoiceButton = document.getElementById('contentEditVoiceButton');
    const titleEditInput = document.getElementById('titleEdit');
    const contentEditInput = document.getElementById('contentEdit');

    let recognition;

    titleEditVoiceButton.addEventListener('click', function () {
        if (!recognition || recognition.ended) {
            startVoiceRecognition(titleEditInput);
            showAlert('Recording for Title...');
        } else {
            recognition.stop();
            showAlert('Recording stopped.');
        }
    });

    contentEditVoiceButton.addEventListener('click', function () {
        if (!recognition || recognition.ended) {
            startVoiceRecognition(contentEditInput);
            showAlert('Recording for Content...');
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

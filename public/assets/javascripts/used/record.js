const video = document.getElementById('video');
const recordedVideo = document.getElementById('recordedVideo');
const startBtn = document.getElementById('start-btn');
const retryBtn = document.getElementById('retry-btn');
const sendBtn = document.getElementById('send-btn');
const sendVideoBtn = document.getElementById('send-video-btn');
const countdown = document.getElementById('countdown');
const videoFrame = document.getElementById('video-frame');

let stream = null;
let mediaRecorder = null;
let recordedBlobs = [];
let countdownTimer = null;

async function requestCameraAccess() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        $('.js--videoAttention').css('display','none')
        $('.js--videoFrame').css('display','block')
        video.srcObject = stream;
        return true;
    } catch (e) {
        alert('Camera access denied or unavailable. Please allow access and retry.');
        return false;
    }
}

function stopStreamTracks() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function startRecording() {
    recordedBlobs = [];
    mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/webm;codecs=vp9,opus' });

    mediaRecorder.ondataavailable = (event) => {
        if (event.data && event.data.size > 0) {
            recordedBlobs.push(event.data);
        }
    };

    mediaRecorder.onstop = () => {
        const recordedBlob = new Blob(recordedBlobs, { type: 'video/webm' });
        recordedVideo.src = URL.createObjectURL(recordedBlob);
        recordedVideo.style.display = 'block';
        $('.js--sendVideo').attr('disabled',false)
        $('.js--videoFrame').css('display','none')
        $('.js--videoPreview').css('display','block')
        $(document).find('.js--restartRec').css('display','');
        $(document).find('.js--sendVideo').css('display','');
        stopStreamTracks();
    };

    mediaRecorder.start();

    // 20-second countdown
    let timeLeft = 10;
    countdown.innerText = timeLeft;
    countdownTimer = setInterval(() => {
        timeLeft--;
        countdown.innerText = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(countdownTimer);
            if (mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
        }
    }, 1000);
}

$('.js--startRec').click(async function (e) {
    e.preventDefault();
    let _this = $(this)
    const accessGranted = await requestCameraAccess();

    if (accessGranted) {
        _this.css('display','none')
        _this.attr('disabled',true);

        startRecording();
    } else {
        // startBtn.disabled = false;
    }
})




var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


$('.js--restartRec').click(async function (e) {
    e.preventDefault();
    let _this = $(this);

    $('.js--videoPreview').hide();
    $('.js--sendVideo').prop('disabled', true);


    // Reset UI
    $('.js--videoFrame').show();
    $('.js--startRec').hide().prop('disabled', true);

    $(document).find('.js--restartRec').hide();
    $(document).find('.js--sendVideo').hide();

    const accessGranted = await requestCameraAccess();
    if (accessGranted) {
        startRecording();
    } else {
        alert('Kamera erişimi alınamadı.');
    }
});

$(document).on('click', '.js--sendVideo', function (e) {
    e.preventDefault();

    const blob = new Blob(recordedBlobs, { type: 'video/webm' });
    const formData = new FormData();
    formData.append('video', blob, 'recorded.webm');

    $('.js--mainSection').hide();
    $('.js--statusSection').show();
    $('.js--spinner').show();
    $('.js--success, .js--error').hide();

    $.ajax({
        url: fileUploadPath,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            $('.js--spinner').hide();
            $('.js--success').show();

            if (res.success && res.redirectUrl){
                window.location.href = res.redirectUrl
            }
        },
        error: function () {
            $('.js--spinner').hide();
            $('.js--error').show();
            setTimeout(function () {
                $('.js--mainSection').show();
                $('.js--statusSection').hide();
            },1000)
        }
    });
});

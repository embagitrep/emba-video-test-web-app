function startCountdown(startTime, minsAfterAvailable, el, par, resendBtn = '') {

    var currentTime = new Date();

    var startDateTime = new Date(currentTime.toDateString() + ' ' + startTime);

    var endDateTime = new Date(startDateTime.getTime() + minsAfterAvailable * 60000);

    function updateCountdown() {
        var now = new Date();
        var diff = endDateTime - now;

        if (diff <= 0) {
            par.hide();
            clearInterval(countdownInterval);
            if (resendBtn !== '') {
                resendBtn.attr('data-clickable', 1);
            }
            return;
        }

        var minutes = Math.floor(diff / 1000 / 60);
        var seconds = Math.floor((diff / 1000) % 60);

        el.text(minutes + ':' + (seconds < 10 ? '0' : '') + seconds);
    }

    var countdownInterval = setInterval(updateCountdown, 1000);

    updateCountdown();
}

export default startCountdown;
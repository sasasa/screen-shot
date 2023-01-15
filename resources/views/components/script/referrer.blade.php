<script>
  /* Remember the transition source and press the back button to return there. */
  const transitionSource = document.referrer;
  if (transitionSource) {
    // return_urlに遷移元のURLをセット
    if(transitionSource !== location.href) {
      document.querySelector('input[name="return_url"]').value = transitionSource;
    }
    if(sessionStorage.getItem('transitionSource')) {
      document.querySelector('input[name="return_url"]').value = sessionStorage.getItem('transitionSource')
    }
    if(sessionStorage.getItem('transitionSource') === null && transitionSource !== location.href) {
      sessionStorage.setItem('transitionSource', transitionSource);
    }
    const backButtons = document.querySelectorAll('.back-button');
    for (let i = 0; i < backButtons.length; i++) {
      backButtons[i].addEventListener('click', function() {
        location.href = sessionStorage.getItem('transitionSource');
        sessionStorage.removeItem('transitionSource');
      });
    }
  }
</script>
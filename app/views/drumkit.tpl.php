 <div id="drumkit">
 
 <div class="keys">
    <div data-key="65" class="key">
      <kbd>A</kbd>
      <span class="sound">clap</span>
    </div>
    <div data-key="90" class="key">
      <kbd>Z</kbd>
      <span class="sound">hihat</span>
    </div>
    <div data-key="69" class="key">
      <kbd>E</kbd>
      <span class="sound">kick</span>
    </div>
    <div data-key="82" class="key">
      <kbd>R</kbd>
      <span class="sound">openhat</span>
    </div>
    <div data-key="84" class="key">
      <kbd>T</kbd>
      <span class="sound">boom</span>
    </div>
    <div data-key="89" class="key">
      <kbd>Y</kbd>
      <span class="sound">ride</span>
    </div>
    <div data-key="85" class="key">
      <kbd>U</kbd>
      <span class="sound">snare</span>
    </div>
    <div data-key="73" class="key">
      <kbd>I</kbd>
      <span class="sound">tom</span>
    </div>
    <div data-key="79" class="key">
      <kbd>O</kbd>
      <span class="sound">tink</span>
    </div>
  </div>

  <audio data-key="65" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/clap.wav"></audio>
  <audio data-key="90" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/hihat.wav"></audio>
  <audio data-key="69" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/kick.wav"></audio>
  <audio data-key="82" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/openhat.wav"></audio>
  <audio data-key="84" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/boom.wav"></audio>
  <audio data-key="89" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/ride.wav"></audio>
  <audio data-key="85" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/snare.wav"></audio>
  <audio data-key="73" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/tom.wav"></audio>
  <audio data-key="79" src="<?= $viewData['urlPrefix'] ?>/assets/sounds/tink.wav"></audio>

  <script>
    function removeTransition(e) {
        if (e.propertyName !== 'transform') return;
        e.target.classList.remove('playing');
    }

    function playSound(e) {
        const audio = document.querySelector(`audio[data-key="${e.keyCode}"]`);
        const key = document.querySelector(`div[data-key="${e.keyCode}"]`);
        if (!audio) return;

        key.classList.add('playing');
        audio.currentTime = 0;
        audio.play();
    }

    const keys = Array.from(document.querySelectorAll('.key'));
    keys.forEach(key => key.addEventListener('transitionend', removeTransition));
    window.addEventListener('keydown', playSound);
  </script>
</div>
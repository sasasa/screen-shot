@props(['time' => 1000])
<script type="module">
/**
 * submitしたら、loadingを表示する
 */
document.querySelector('.inputbox__submit').addEventListener('click', function() {
  setTimeout(() => {
    this.disabled = true;
  }, 30);
  setTimeout(() => {
    document.getElementById('loading').style.display = 'block';
  }, Number({{ $time }}));
});
</script>
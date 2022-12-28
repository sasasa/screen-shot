import './bootstrap';

/**
Get brightness from rgb
 */
// function getBrightness(r, g, b) {
//     return Math.round(((parseInt(r) * 299) + (parseInt(g) * 587) + (parseInt(b) * 114)) / 1000);
// }
/**
 * Sensing that the background is dark, the text color is set to white.
 */
// function setTextColor() {
//   document.querySelectorAll('.color').forEach(color => {
//       const rgb = window.getComputedStyle(color).backgroundColor.match(/\d+/g);
//       const brightness = getBrightness(rgb[0], rgb[1], rgb[2]);
//       if (brightness < 125) {
//           color.classList.add('text-white');
//       }
//   });
// }

// window.addEventListener('DOMContentLoaded', () => {
//   setTextColor();
// });
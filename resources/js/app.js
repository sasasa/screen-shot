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

// いいね機能
let likeIcons = document.querySelectorAll('.like-icon');
//likeアイコンをクリックしたらSVGの色を変える
likeIcons.forEach(function(likeIcon) {
  likeIcon.addEventListener('click', function() {
    const siteid = this.getAttribute('data-siteid');
    if (this.getAttribute('fill') === '#aaaaaa') {
      // like
      axios.post('/api/likes', {
        siteid: siteid
      }).then((response) => {
        console.log(response);
        this.setAttribute('fill', '#ffff00');
        document.querySelectorAll(".like-icon" + siteid).forEach(function(icon) {
          icon.setAttribute('fill', '#ffff00');
        });
        document.querySelectorAll(`.like-number${siteid}`).forEach(function(likeNumber) {
          likeNumber.textContent = response.data.likes_count;
        });
      }).catch((error) => {
        console.log(error);
      });
    } else {
      // unlike
      axios.delete('/api/likes', {
        data: {
          siteid: siteid
        }
      }).then((response) => {
        console.log(response);
        this.setAttribute('fill', '#aaaaaa');
        document.querySelectorAll(".like-icon" + siteid).forEach(function(icon) {
          icon.setAttribute('fill', '#aaaaaa');
        });
        document.querySelectorAll(`.like-number${siteid}`).forEach(function(likeNumber) {
          likeNumber.textContent = response.data.likes_count;
        });
      }).catch((error) => {
        console.log(error);
      });
    }
  });
});
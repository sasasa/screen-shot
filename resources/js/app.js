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
const appendAll = (parent, elems) => {
  elems.forEach(elem => parent.appendChild(elem))
}

const removeAll = (elems) => {
  elems.forEach(elem => elem.parentNode?.removeChild(elem))
}

const createElementsWithClass = (count, tagName = 'div', className = '') => {
  return Array(count)
    .fill(0)
    .map(() => {
      const elem = document.createElement(tagName)
      elem.className = className
      return elem
    });
};
// 中央の星を縮めてから大きくする
const popCenterStar = async (star) => {
  // 中央の星を縮める
  await star.animate([{ transform: `scale(1)` }, { transform: `scale(0.6)` }], {
    duration: 150
  }).finished;

  // 中央の星を下の大きさに戻す
  // このアニメーションは完了を待たずに次の処理に移る
  star.animate(
    [
      { transform: `scale(0.6)`, filter: `blur(0)` },
      { transform: `scale(2.4)`, filter: `blur(2px)`, offset: 0.3 },
      { transform: `scale(1)`, filter: `blur(0)` }
    ],
    {
      duration: 1000,
      easing: "ease-out"
    }
  );
};
// クリック時のアニメーション
const emitParticles = async (star) => {
  await popCenterStar(star);

  // div.dotをCOUNT個作成
  const COUNT = 30;
  const dots = createElementsWithClass(COUNT, "span", "dot");
  appendAll(star.parentNode, dots); // 画面に表示
  // console.log(star.parentNode)
  const animations = dots.map((dot) => {
    const angle = 360 * Math.random();
    const dist = 100 + 50 * Math.random();
    const size = 0.5 + Math.random() * 2;
    const hue = 30 + Math.random() * 25;
    dot.style.backgroundColor = `hsl(${hue}, 90%, 60%)`;

    const hasBlendmode = Math.random() > 0.5;
    const hasBlur = Math.random() > 0.5;
    if (hasBlendmode) {
      dot.style.mixBlendMode = "add";
    }
    if (hasBlur) {
      dot.style.filter = `blur(${Math.random() * 20}px)`;
    }
    return dot.animate(
      [
        {
          transform: `rotate(${angle}deg) translateX(0px) scale(${size})`,
          opacity: 0.8
        },
        {
          transform: `rotate(${angle}deg) translateX(${
            dist * 0.8
          }px) scale(${size})`,
          opacity: 0.8,
          offset: 0.8
        },
        {
          transform: `rotate(${angle}deg) translateX(${dist}px) scale(${size})`,
          opacity: 0
        }
      ],
      {
        duration: 2000 * Math.random(),
        fill: "forwards"
      }
    );
  });
  // 全てのアニメーションが終わるまで待つ
  await Promise.all(animations.map((anim) => anim.finished));
  removeAll(dots); // 削除
};


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
          emitParticles(icon);
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
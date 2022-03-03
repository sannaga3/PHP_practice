let data;

function chart() {
  const $chartArea = document.querySelector('#chart');
  if (!$chartArea) return;

  const ctx = $chartArea.getContext('2d');
  const likes = $chartArea.dataset.likes;
  const dislikes = $chartArea.dataset.dislikes;

  if (likes == 0 && dislikes == 0) {
    data = {
      labels: ['まだ投票がありません'],
      datasets: [{
          data: [1],
          backgroundColor: [
              '#dcdcdc',
          ],
      }]
    }
  } else {
    data = {
      labels: ['賛成', '反対'],
      datasets: [{
          data: [likes, dislikes],
          backgroundColor: [
              '#ff7f50',
              '#6495ed',
          ],
      }]
    }
  }

  new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
      responsive: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            font: {
              size: 30
            }
          }
        },
      }
    }
  })
}
chart();
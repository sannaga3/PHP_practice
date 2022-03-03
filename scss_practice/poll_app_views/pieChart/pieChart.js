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


// function chart() {
//   const $chartArea = document.querySelector('#Chart');
//   const ctx = $chartArea.getContext('2d');
//   new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
//         datasets: [{
//             label: '# of Votes',
//             data: [12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
//   })
// }
// chart();
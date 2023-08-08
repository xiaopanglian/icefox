import './css/tailwind.css'
import './css/main.css'
import prism from 'prismjs'

prism.highlightAll();

// let themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
// let themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
//
// // Change the icons inside the button based on previous settings
// if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
//     themeToggleLightIcon.classList.remove('hidden');
// } else {
//     themeToggleDarkIcon.classList.remove('hidden');
// }
//
// let themeToggleBtn = document.getElementById('theme-toggle');
//
// if (localStorage.getItem('color-theme') === 'dark') {
//     document.documentElement.classList.add('dark');
// } else {
//     document.documentElement.classList.remove('dark');
// }
//
// themeToggleBtn.addEventListener('click', function () {
//     // toggle icons inside button
//     themeToggleDarkIcon.classList.toggle('hidden');
//     themeToggleLightIcon.classList.toggle('hidden');
//
//     // if set via local storage previously
//     if (localStorage.getItem('color-theme')) {
//         if (localStorage.getItem('color-theme') === 'light') {
//             document.documentElement.classList.add('dark');
//             localStorage.setItem('color-theme', 'dark');
//         } else {
//             document.documentElement.classList.remove('dark');
//             localStorage.setItem('color-theme', 'light');
//         }
//
//         // if NOT set via local storage previously
//     } else {
//         if (document.documentElement.classList.contains('dark')) {
//             document.documentElement.classList.remove('dark');
//             localStorage.setItem('color-theme', 'light');
//         } else {
//             document.documentElement.classList.add('dark');
//             localStorage.setItem('color-theme', 'dark');
//         }
//     }
//
// });

window.onload = function () {
    let commentElements = document.querySelectorAll(".toggleCommentTip");

    commentElements.forEach(element => {
        element.addEventListener("click", (event) => {
            let element = getParent(event.target);
            HiddenAllCommentTip(element);
            let classList = element.classList;
            if (classList.contains('hidden')) {
                element.classList.remove('hidden')
            } else {
                element.classList.add('hidden')
            }

        }, true);
    })

}


function getParent(element) {
    if (element.classList.contains('commentPoint')) {
        return element.nextElementSibling;
    } else {
        return getParent(element.parentElement);
    }
}

function HiddenAllCommentTip(element) {
    let commentTipElements = document.querySelectorAll('.commentTip');
    commentTipElements.forEach(item => {
            if (item !== element && !item.classList.contains('hidden')) {
                item.classList.add('hidden')
            }

        }
    )
}